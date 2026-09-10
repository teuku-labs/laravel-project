<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kaprodi;
use App\Models\SeminarLkp;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\PengajuanSk;
use App\Models\Sidang;
use App\Models\PengajuanPembimbing;
use App\Models\Dosen;

class KaprodiController extends Controller
{
    private function getKaprodi()
    {
        return Kaprodi::where('user_id', Auth::id())->first();
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Data Kaprodi tidak ditemukan.']);
        }

        $totalMahasiswa    = Mahasiswa::where('prodi_id', $kaprodi->prodi_id)->count();
        $totalSeminarLkp   = SeminarLkp::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))->count();
        $pendingSeminarLkp = SeminarLkp::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
                                ->whereNull('tanggal_seminar')->count();
        $totalJadwal       = Jadwal::count();

        $seminarList = SeminarLkp::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
                        ->with(['mahasiswa', 'dosen'])
                        ->latest()->take(5)->get();

        // ✅ Fitur Dosen Pembimbing — pengajuan bimbingan ke Kaprodi
        $pengajuanBimbingan = PengajuanPembimbing::where('dosen_id', $kaprodi->user_id)
                                ->where('status', 'pending')
                                ->with('mahasiswa.prodi')
                                ->get();

        // Mahasiswa yang Kaprodi jadi pembimbing (via user_id mapping ke dosen)
        $mahasiswaBimbingan = Mahasiswa::where('pembimbing1_id', $kaprodi->user_id)
                                ->orWhere('pembimbing2_id', $kaprodi->user_id)
                                ->count();

        return view('kaprodi.dashboard', compact(
            'kaprodi', 'totalMahasiswa', 'totalSeminarLkp',
            'pendingSeminarLkp', 'totalJadwal', 'seminarList',
            'pengajuanBimbingan', 'mahasiswaBimbingan'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SEMINAR LKP
    |--------------------------------------------------------------------------
    */
    public function seminar()
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $seminarList = SeminarLkp::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
                        ->with(['mahasiswa', 'dosen'])->latest()->get();

        return view('kaprodi.seminar', compact('kaprodi', 'seminarList'));
    }

    public function seminarShow($id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $seminar = SeminarLkp::with(['mahasiswa', 'dosen', 'penguji'])
            ->whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->findOrFail($id);

        $dosenList = Dosen::where('prodi_id', $kaprodi->prodi_id)->orderBy('nama')->get();

        return view('kaprodi.seminar-show', compact('kaprodi', 'seminar', 'dosenList'));
    }

    public function seminarUpdatePembimbing(Request $request, $id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
        ]);

        $seminar = SeminarLkp::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->findOrFail($id);

        // Pastikan dosen yang dipilih berasal dari prodi yang sama
        $dosen = Dosen::where('prodi_id', $kaprodi->prodi_id)->findOrFail($request->dosen_id);

        $seminar->update(['pembimbing1_id' => $dosen->id]);

        return back()->with('success', 'Dosen pembimbing LKP berhasil diperbarui.');
    }

    public function seminarUpdatePenguji(Request $request, $id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $request->validate([
            'penguji_id' => 'required|exists:dosen,id',
        ]);

        $seminar = SeminarLkp::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->findOrFail($id);

        // Pastikan dosen yang dipilih berasal dari prodi yang sama
        $dosen = Dosen::where('prodi_id', $kaprodi->prodi_id)->findOrFail($request->penguji_id);

        if ($seminar->pembimbing1_id == $dosen->id) {
            return back()->withErrors(['penguji_id' => 'Dosen pembahas/penguji tidak boleh sama dengan dosen pembimbing.']);
        }

        $seminar->update(['penguji_id' => $dosen->id]);

        return back()->with('success', 'Dosen pembahas/penguji seminar LKP berhasil ditetapkan.');
    }

    public function seminarJadwal(Request $request, $id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $request->validate([
            'tanggal_seminar' => 'required|date|after:today',
            'waktu'           => 'required',
            'ruang'           => 'required|string|max:50',
        ]);

        $seminar = SeminarLkp::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->findOrFail($id);

        // Waktu selesai otomatis: 1 jam 30 menit setelah waktu mulai
        $waktuSelesai = \Carbon\Carbon::createFromFormat('H:i', $request->waktu)->addMinutes(90)->format('H:i');

        Jadwal::updateOrCreate(
            ['mahasiswa_id' => $seminar->mahasiswa_id, 'jenis' => 'lkp'],
            [
                'dosen_id'      => $seminar->pembimbing1_id,
                'tanggal'       => $request->tanggal_seminar,
                'waktu'         => $request->waktu,
                'waktu_selesai' => $waktuSelesai,
                'ruang'         => $request->ruang,
                'jenis'         => 'lkp',
            ]
        );

        $seminar->update(['tanggal_seminar' => $request->tanggal_seminar]);
        return back()->with('success', 'Jadwal seminar LKP berhasil ditetapkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SK PEMBIMBING
    |--------------------------------------------------------------------------
    */
    public function skPembimbingIndex()
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $pengajuanSks = PengajuanSk::with(['mahasiswa', 'pembimbing1', 'pembimbing2'])
            ->whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)
            ->latest()->paginate(15);

        return view('kaprodi.sk-pembimbing.index', compact('kaprodi', 'pengajuanSks'));
    }

    public function skPembimbingShow($id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $pengajuan = PengajuanSk::with(['mahasiswa', 'pembimbing1', 'pembimbing2'])
            ->whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)->findOrFail($id);

        return view('kaprodi.sk-pembimbing.show', compact('kaprodi', 'pengajuan'));
    }

    public function skPembimbingApprove($id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $pengajuan = PengajuanSk::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)->findOrFail($id);

        $pengajuan->update([
            'kaprodi_approved' => true,
            'kaprodi_rejected' => false,
            'catatan_kaprodi'  => null,
        ]);

        return back()->with('success', 'Pengajuan SK Pembimbing berhasil disetujui.');
    }

    public function skPembimbingReject(Request $request, $id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $request->validate(['catatan_kaprodi' => 'required|string|max:500']);

        $pengajuan = PengajuanSk::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)->findOrFail($id);

        $pengajuan->update([
            'kaprodi_rejected' => true,
            'kaprodi_approved' => false,
            'catatan_kaprodi'  => $request->catatan_kaprodi,
        ]);

        return back()->with('success', 'Pengajuan SK Pembimbing ditolak.');
    }

    /*
    |--------------------------------------------------------------------------
    | SIDANG
    |--------------------------------------------------------------------------
    */
    public function sidangIndex()
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $sidangs = Sidang::with(['mahasiswa', 'pembimbing'])
            ->whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)->latest()->paginate(15);

        return view('kaprodi.sidang.index', compact('kaprodi', 'sidangs'));
    }

    public function sidangShow($id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $sidang = Sidang::with(['mahasiswa.prodi', 'pembimbing'])
            ->whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)->findOrFail($id);

        return view('kaprodi.sidang.show', compact('kaprodi', 'sidang'));
    }

    public function sidangApprove($id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $sidang = Sidang::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)->findOrFail($id);

        $sidang->update(['kaprodi_approved' => true, 'kaprodi_rejected' => false, 'catatan_kaprodi' => null]);
        return back()->with('success', 'Pengajuan Sidang Skripsi berhasil disetujui.');
    }

    public function sidangReject(Request $request, $id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $request->validate(['catatan_kaprodi' => 'required|string|max:500']);

        $sidang = Sidang::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)->findOrFail($id);

        $sidang->update(['kaprodi_rejected' => true, 'kaprodi_approved' => false, 'catatan_kaprodi' => $request->catatan_kaprodi]);
        return back()->with('success', 'Pengajuan Sidang Skripsi ditolak.');
    }

    /*
    |--------------------------------------------------------------------------
    | ✅ FITUR DOSEN PEMBIMBING — Pengajuan Bimbingan
    |--------------------------------------------------------------------------
    */
    public function bimbinganIndex()
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        // Pengajuan yang masih pending
        $pengajuanPending = PengajuanPembimbing::where('dosen_id', $kaprodi->user_id)
                            ->where('status', 'pending')
                            ->with('mahasiswa.prodi')->latest()->get();

        // Riwayat yang sudah diproses
        $riwayatPengajuan = PengajuanPembimbing::where('dosen_id', $kaprodi->user_id)
                            ->whereIn('status', ['approved', 'rejected'])
                            ->with('mahasiswa.prodi')->latest()->get();

        // Mahasiswa yang sudah dibimbing
        $mahasiswaBimbingan = Mahasiswa::where('pembimbing1_id', $kaprodi->user_id)
                                ->orWhere('pembimbing2_id', $kaprodi->user_id)
                                ->with('prodi')->get();

        $mahasiswaCount = $mahasiswaBimbingan->count();

        return view('kaprodi.bimbingan', compact(
            'kaprodi', 'pengajuanPending', 'riwayatPengajuan',
            'mahasiswaBimbingan', 'mahasiswaCount'
        ));
    }

    public function bimbinganApprove($id)
    {
        $kaprodi   = $this->getKaprodi();
        $pengajuan = PengajuanPembimbing::where('id', $id)
                        ->where('dosen_id', $kaprodi->user_id)->firstOrFail();

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $mahasiswa = $pengajuan->mahasiswa;
        $jenis     = explode('|', $pengajuan->catatan)[0];

        if ($jenis === 'pembimbing1') {
            $mahasiswa->pembimbing1_id = $kaprodi->user_id;
        } else {
            $mahasiswa->pembimbing2_id = $kaprodi->user_id;
        }
        $mahasiswa->save();

        $pengajuan->update(['status' => 'approved']);

        // Auto-reject pengajuan lain dari mahasiswa yang sama untuk slot yang sama
        PengajuanPembimbing::where('mahasiswa_id', $mahasiswa->id)
            ->where('id', '!=', $id)
            ->where('catatan', 'like', $jenis . '%')
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);

        return back()->with('success', 'Permintaan bimbingan dari ' . $mahasiswa->nama . ' disetujui.');
    }

    public function bimbinganReject(Request $request, $id)
    {
        $kaprodi   = $this->getKaprodi();
        $pengajuan = PengajuanPembimbing::where('id', $id)
                        ->where('dosen_id', $kaprodi->user_id)->firstOrFail();

        $jenis  = explode('|', $pengajuan->catatan)[0];
        $alasan = $request->alasan ?: 'Tidak ada alasan';

        $pengajuan->update(['status' => 'rejected', 'catatan' => $jenis . '|' . $alasan]);
        return back()->with('success', 'Permintaan bimbingan dari ' . $pengajuan->mahasiswa->nama . ' ditolak.');
    }

    /*
    |--------------------------------------------------------------------------
    | ✅ JADWAL SAYA (sebagai pembimbing)
    |--------------------------------------------------------------------------
    */
    public function jadwalSaya()
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $jadwals = Jadwal::where('dosen_id', $kaprodi->user_id)
                    ->with('mahasiswa')->orderBy('tanggal', 'asc')->get();

        return view('kaprodi.jadwal-saya', compact('kaprodi', 'jadwals'));
    }

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    public function profile()
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $mahasiswaBimbingan = Mahasiswa::where('pembimbing1_id', $kaprodi->user_id)
                                ->orWhere('pembimbing2_id', $kaprodi->user_id)->count();
        $pengajuanBaru      = PengajuanPembimbing::where('dosen_id', $kaprodi->user_id)
                                ->where('status', 'pending')->count();

        return view('kaprodi.profile', compact('kaprodi', 'mahasiswaBimbingan', 'pengajuanBaru'));
    }
}