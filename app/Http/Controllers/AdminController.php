<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Dosen;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Kaprodi;
use App\Models\Dekan;
use App\Models\SeminarLkp;
use App\Models\Prodi;
use App\Models\PengajuanSk;
use App\Models\Sidang;
use Illuminate\Support\Facades\DB; // FIX: untuk transaksi

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $totalDosen      = Dosen::count();
        $newDosen        = Dosen::whereMonth('created_at', now()->month)->count();
        $totalKaprodi    = Kaprodi::count();
        $totalDekan      = Dekan::count();
        $totalMahasiswa  = Mahasiswa::count();
        $newMahasiswa    = Mahasiswa::whereMonth('created_at', now()->month)->count();
        $totalSeminarLkp = SeminarLkp::count();
        $pendingSeminar  = SeminarLkp::whereNull('tanggal_seminar')->count();

        $seminarTerbaru = SeminarLkp::with(['mahasiswa', 'dosen'])
                            ->latest()->take(5)->get();

        $mahasiswaTerbaru = Mahasiswa::with(['prodi', 'pembimbing1'])
                            ->latest()->take(5)->get();

        $skPembimbingList = PengajuanSk::with(['mahasiswa', 'pembimbing1', 'pembimbing2'])
                            ->latest()->take(5)->get();

        $seminarRegistrations = Sidang::with(['mahasiswa', 'pembimbing'])
                            ->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalDosen', 'newDosen',
            'totalKaprodi', 'totalDekan',
            'totalMahasiswa', 'newMahasiswa',
            'totalSeminarLkp', 'pendingSeminar',
            'seminarTerbaru', 'mahasiswaTerbaru',
            'skPembimbingList', 'seminarRegistrations'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | KAPRODI — CRUD
    |--------------------------------------------------------------------------
    */
    public function kaprodiIndex()
    {
        $kaprodis = Kaprodi::with(['prodi', 'user'])->latest()->paginate(10);
        $prodis   = Prodi::all();
        return view('admin.kaprodi.index', compact('kaprodis', 'prodis'));
    }

    public function kaprodiCreate()
    {
        $prodis = Prodi::all();
        return view('admin.kaprodi.create', compact('prodis'));
    }

    public function kaprodiStore(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'nuptk'    => 'required|unique:kaprodi,nuptk|unique:dosen,nuptk',
            'email'    => 'required|email|unique:users,email',
            'prodi_id' => 'required|exists:prodi,id',
        ], [
            'nuptk.unique'  => 'NUPTK sudah terdaftar.',
            'email.unique'  => 'Email sudah digunakan.',
        ]);

        // FIX: bungkus dalam transaksi supaya tidak ada User "yatim" kalau insert Kaprodi gagal
        DB::transaction(function () use ($request) {
            $user = User::create([
                'username'  => $request->nama,
                'email'     => $request->email,
                'nim_nuptk' => $request->nuptk,
                'password'  => Hash::make('password123'),
                'role'      => 'kaprodi',
            ]);

            Kaprodi::create([
                'user_id'  => $user->id,
                'prodi_id' => $request->prodi_id,
                'nuptk'    => $request->nuptk,
                'nama'     => $request->nama,
            ]);

            // FIX: agar Kaprodi juga muncul di pilihan dosen pembimbing (LKP/Proposal/Skripsi),
            // buat baris terkait di tabel dosen. Tabel dosen tidak diubah strukturnya sama sekali.
            Dosen::create([
                'user_id'  => $user->id,
                'prodi_id' => $request->prodi_id,
                'nuptk'    => $request->nuptk,
                'nama'     => $request->nama,
            ]);
        });

        return redirect()->route('admin.kaprodi.index')
            ->with('success', 'Kaprodi berhasil ditambahkan. Password default: password123');
    }

    public function kaprodiEdit($id)
    {
        $kaprodi = Kaprodi::findOrFail($id);
        $prodis  = Prodi::all();
        return view('admin.kaprodi.edit', compact('kaprodi', 'prodis'));
    }

    public function kaprodiUpdate(Request $request, $id)
    {
        $kaprodi = Kaprodi::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'nuptk'    => 'required|unique:kaprodi,nuptk,' . $id . '|unique:dosen,nuptk,' . $kaprodi->user_id . ',user_id',
            'prodi_id' => 'required|exists:prodi,id',
        ]);

        $kaprodi->update([
            'nama'     => $request->nama,
            'nuptk'    => $request->nuptk,
            'prodi_id' => $request->prodi_id,
        ]);

        // Update user juga
        $kaprodi->user->update([
            'username'  => $request->nama,
            'nim_nuptk' => $request->nuptk,
        ]);

        // FIX: sinkronkan juga baris dosen terkait supaya data pembimbing tidak basi
        Dosen::where('user_id', $kaprodi->user_id)->update([
            'nama'     => $request->nama,
            'nuptk'    => $request->nuptk,
            'prodi_id' => $request->prodi_id,
        ]);

        return redirect()->route('admin.kaprodi.index')
            ->with('success', 'Data Kaprodi berhasil diperbarui.');
    }

    public function kaprodiDestroy($id)
    {
        $kaprodi = Kaprodi::findOrFail($id);
        $user    = $kaprodi->user;
        $kaprodi->delete();
        $user?->delete();

        return back()->with('success', 'Data Kaprodi berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | DEKAN — CRUD
    |--------------------------------------------------------------------------
    */
    public function dekanIndex()
    {
        $dekans = Dekan::with(['prodi', 'user'])->latest()->paginate(10);
        $prodis = Prodi::all();
        return view('admin.dekan.index', compact('dekans', 'prodis'));
    }

    public function dekanCreate()
    {
        $prodis = Prodi::all();
        return view('admin.dekan.create', compact('prodis'));
    }

    public function dekanStore(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'nuptk'    => 'required|unique:dekan,nuptk|unique:dosen,nuptk',
            'email'    => 'required|email|unique:users,email',
            'prodi_id' => 'required|exists:prodi,id',
        ], [
            'nuptk.unique' => 'NUPTK sudah terdaftar.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        // FIX: bungkus dalam transaksi supaya tidak ada User "yatim" kalau insert Dekan gagal
        DB::transaction(function () use ($request) {
            $user = User::create([
                'username'  => $request->nama,
                'email'     => $request->email,
                'nim_nuptk' => $request->nuptk,
                'password'  => Hash::make('password123'),
                'role'      => 'dekan',
            ]);

            Dekan::create([
                'user_id'  => $user->id,
                'prodi_id' => $request->prodi_id,
                'nuptk'    => $request->nuptk,
                'nama'     => $request->nama,
            ]);

            // FIX: agar Dekan juga muncul di pilihan dosen pembimbing (LKP/Proposal/Skripsi),
            // buat baris terkait di tabel dosen. Tabel dosen tidak diubah strukturnya sama sekali.
            Dosen::create([
                'user_id'  => $user->id,
                'prodi_id' => $request->prodi_id,
                'nuptk'    => $request->nuptk,
                'nama'     => $request->nama,
            ]);
        });

        return redirect()->route('admin.dekan.index')
            ->with('success', 'Dekan berhasil ditambahkan. Password default: password123');
    }

    public function dekanEdit($id)
    {
        $dekan  = Dekan::findOrFail($id);
        $prodis = Prodi::all();
        return view('admin.dekan.edit', compact('dekan', 'prodis'));
    }

    public function dekanUpdate(Request $request, $id)
    {
        $dekan = Dekan::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'nuptk'    => 'required|unique:dekan,nuptk,' . $id . '|unique:dosen,nuptk,' . $dekan->user_id . ',user_id',
            'prodi_id' => 'required|exists:prodi,id',
        ]);

        $dekan->update([
            'nama'     => $request->nama,
            'nuptk'    => $request->nuptk,
            'prodi_id' => $request->prodi_id,
        ]);

        $dekan->user->update([
            'username'  => $request->nama,
            'nim_nuptk' => $request->nuptk,
        ]);

        // FIX: sinkronkan juga baris dosen terkait supaya data pembimbing tidak basi
        Dosen::where('user_id', $dekan->user_id)->update([
            'nama'     => $request->nama,
            'nuptk'    => $request->nuptk,
            'prodi_id' => $request->prodi_id,
        ]);

        return redirect()->route('admin.dekan.index')
            ->with('success', 'Data Dekan berhasil diperbarui.');
    }

    public function dekanDestroy($id)
    {
        $dekan = Dekan::findOrFail($id);
        $user  = $dekan->user;
        $dekan->delete();
        $user?->delete();

        return back()->with('success', 'Data Dekan berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | MAHASISWA — View Only
    |--------------------------------------------------------------------------
    */
    public function mahasiswaIndex(Request $request)
    {
        $query = Mahasiswa::with(['prodi', 'pembimbing1']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->prodi_id) {
            $query->where('prodi_id', $request->prodi_id);
        }

        $mahasiswas = $query->latest()->paginate(15)->withQueryString();
        $prodis     = Prodi::all();

        return view('admin.mahasiswa.index', compact('mahasiswas', 'prodis'));
    }

    public function mahasiswaShow($id)
    {
        $mahasiswa = Mahasiswa::with(['prodi', 'pembimbing1', 'pembimbing2', 'seminarLkp'])->findOrFail($id);
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /*
    |--------------------------------------------------------------------------
    | SEMINAR LKP — View + Verifikasi
    |--------------------------------------------------------------------------
    */
    public function seminarIndex(Request $request)
    {
        $query = SeminarLkp::with(['mahasiswa', 'dosen']);

        if ($request->search) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status === 'terjadwal') {
            $query->whereNotNull('tanggal_seminar');
        } elseif ($request->status === 'pending') {
            $query->whereNull('tanggal_seminar');
        }

        $seminars    = $query->latest()->paginate(15)->withQueryString();
        $totalSeminar = SeminarLkp::count();
        $pending      = SeminarLkp::whereNull('tanggal_seminar')->count();
        $terjadwal    = SeminarLkp::whereNotNull('tanggal_seminar')->count();

        return view('admin.seminar.index', compact(
            'seminars', 'totalSeminar', 'pending', 'terjadwal'
        ));
    }

    public function seminarShow($id)
    {
        $seminar = SeminarLkp::with(['mahasiswa', 'dosen'])->findOrFail($id);
        return view('admin.seminar.show', compact('seminar'));
    }

    /*
    |--------------------------------------------------------------------------
    | SK PEMBIMBING
    |--------------------------------------------------------------------------
    */
    public function skPembimbingIndex()
    {
        $pengajuanSks = PengajuanSk::with(['mahasiswa', 'pembimbing1', 'pembimbing2'])->latest()->paginate(15);
        return view('admin.sk-pembimbing.index', compact('pengajuanSks'));
    }

    public function skPembimbingEdit($id)
    {
        $pengajuan = PengajuanSk::findOrFail($id);
        return view('admin.sk-pembimbing.edit', compact('pengajuan'));
    }

    public function skPembimbingUpdate(Request $request, $id)
    {
        $pengajuan = PengajuanSk::findOrFail($id);
        
        $request->validate([
            'nomor_sk' => 'nullable|string|max:255',
        ]);

        $pengajuan->update([
            'nomor_sk' => $request->nomor_sk,
            'admin_verified' => true,
        ]);

        return redirect()->route('admin.sk-pembimbing.index')->with('success', 'SK Pembimbing berhasil diperbarui.');
    }

    public function skPembimbingShow($id)
    {
        $pengajuan = PengajuanSk::findOrFail($id);
        return view('admin.sk-pembimbing.show', compact('pengajuan'));
    }

    public function skPembimbingSubmitApproval(Request $request, $id)
    {
        $pengajuan = PengajuanSk::findOrFail($id);
        $pengajuan->update([
            'admin_verified' => true
        ]);
        
        return back()->with('success', 'SK Pembimbing berhasil diverifikasi dan dikirim ke Kaprodi.');
    }

    /*
    |--------------------------------------------------------------------------
    | PENGAJUAN SIDANG
    |--------------------------------------------------------------------------
    */
    public function sidangIndex()
    {
        $sidangs           = Sidang::with(['mahasiswa', 'pembimbing'])->latest()->paginate(15);
        $totalSidang       = Sidang::count();
        $belumVerifikasi   = Sidang::where('admin_verified', false)->count();
        $disetujuiKaprodi  = Sidang::where('kaprodi_approved', true)->count();

        return view('admin.sidang.index', compact(
            'sidangs', 'totalSidang', 'belumVerifikasi', 'disetujuiKaprodi'
        ));
    }

    public function sidangShow($id)
    {
        $sidang = Sidang::with(['mahasiswa.prodi', 'pembimbing'])->findOrFail($id);
        return view('admin.sidang.show', compact('sidang'));
    }

    /**
     * Admin hanya memverifikasi kelengkapan berkas & meneruskan ke Kaprodi.
     * Keputusan setuju/tolak sepenuhnya ada di tangan Kaprodi (sama seperti
     * alur SK Pembimbing).
     */
    public function sidangVerify($id)
    {
        $sidang = Sidang::findOrFail($id);

        if ($sidang->admin_verified) {
            return back()->with('error', 'Pengajuan sidang ini sudah diverifikasi sebelumnya.');
        }

        $sidang->update(['admin_verified' => true]);

        return back()->with('success', 'Pengajuan sidang berhasil diverifikasi dan dikirim ke Kaprodi.');
    }

    /*
    |--------------------------------------------------------------------------
    | PROFILE & SETTINGS
    |--------------------------------------------------------------------------
    */
    public function profile()
    {
        return view('admin.profile', ['user' => Auth::user()]);
    }

    public function settings()
    {
        return view('admin.settings', ['user' => Auth::user()]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ], [
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
            'new_password.min'       => 'Password minimal 8 karakter.',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        Auth::user()->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}