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
                        ->latest()
                        ->take(10)
                        ->get();

        return view('kaprodi.dashboard', compact(
            'kaprodi',
            'totalMahasiswa',
            'totalSeminarLkp',
            'pendingSeminarLkp',
            'totalJadwal',
            'seminarList'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | DAFTAR SEMINAR LKP
    |--------------------------------------------------------------------------
    */
    public function seminar()
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $seminarList = SeminarLkp::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
                        ->with(['mahasiswa', 'dosen'])
                        ->latest()
                        ->get();

        return view('kaprodi.seminar', compact('kaprodi', 'seminarList'));
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL SEMINAR LKP
    |--------------------------------------------------------------------------
    */
    public function seminarShow($id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        // FIX: sebelumnya findOrFail($id) tanpa syarat apa pun, sehingga Kaprodi
        // prodi A bisa mengetik ID seminar milik prodi B di URL dan tetap melihatnya
        // (Insecure Direct Object Reference). Sekarang dibatasi ke prodi kaprodi ini saja.
        $seminar = SeminarLkp::with(['mahasiswa', 'dosen'])
            ->whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->findOrFail($id);

        return view('kaprodi.seminar-show', compact('kaprodi', 'seminar'));
    }

    /*
    |--------------------------------------------------------------------------
    | SET JADWAL SEMINAR LKP
    |--------------------------------------------------------------------------
    */
    public function seminarJadwal(Request $request, $id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $request->validate([
            'tanggal_seminar' => 'required|date|after:today',
            'waktu'           => 'required',
            'ruang'           => 'required|string|max:50',
        ], [
            'tanggal_seminar.required' => 'Tanggal seminar wajib diisi.',
            'tanggal_seminar.after'    => 'Tanggal seminar harus setelah hari ini.',
            'waktu.required'           => 'Waktu seminar wajib diisi.',
            'ruang.required'           => 'Ruang seminar wajib diisi.',
        ]);

        // FIX: sama seperti seminarShow(), cegah kaprodi menjadwalkan seminar
        // mahasiswa di luar prodi-nya.
        $seminar = SeminarLkp::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->findOrFail($id);

        // Simpan jadwal ke tabel jadwals
        Jadwal::updateOrCreate(
            ['mahasiswa_id' => $seminar->mahasiswa_id, 'jenis' => 'lkp'],
            [
                'dosen_id' => $seminar->pembimbing1_id,
                'tanggal'  => $request->tanggal_seminar,
                'waktu'    => $request->waktu,
                'ruang'    => $request->ruang,
                'jenis'    => 'lkp',
            ]
        );

        // Tandai seminar sudah dijadwalkan
        $seminar->update(['tanggal_seminar' => $request->tanggal_seminar]);

        return back()->with('success', 'Jadwal seminar LKP berhasil ditetapkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SK PEMBIMBING — Approve / Reject
    |--------------------------------------------------------------------------
    */
    public function skPembimbingIndex()
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        // Kaprodi hanya menangani pengajuan yang sudah diverifikasi Admin
        // dan hanya untuk mahasiswa di prodi-nya sendiri.
        $pengajuanSks = PengajuanSk::with(['mahasiswa', 'pembimbing1', 'pembimbing2'])
            ->whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)
            ->latest()
            ->paginate(15);

        return view('kaprodi.sk-pembimbing.index', compact('kaprodi', 'pengajuanSks'));
    }

    public function skPembimbingShow($id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        // Cegah kaprodi prodi lain mengakses pengajuan SK di luar prodinya (IDOR).
        $pengajuan = PengajuanSk::with(['mahasiswa', 'pembimbing1', 'pembimbing2'])
            ->whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)
            ->findOrFail($id);

        return view('kaprodi.sk-pembimbing.show', compact('kaprodi', 'pengajuan'));
    }

    public function skPembimbingApprove($id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $pengajuan = PengajuanSk::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)
            ->findOrFail($id);

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

        $request->validate([
            'catatan_kaprodi' => 'required|string|max:500',
        ], [
            'catatan_kaprodi.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $pengajuan = PengajuanSk::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)
            ->findOrFail($id);

        $pengajuan->update([
            'kaprodi_rejected' => true,
            'kaprodi_approved' => false,
            'catatan_kaprodi'  => $request->catatan_kaprodi,
        ]);

        return back()->with('success', 'Pengajuan SK Pembimbing ditolak.');
    }

    /*
    |--------------------------------------------------------------------------
    | SIDANG SKRIPSI — Approve / Reject
    |--------------------------------------------------------------------------
    */
    public function sidangIndex()
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        // Sama seperti SK Pembimbing: Kaprodi hanya menangani pengajuan yang
        // sudah diverifikasi Admin, dan hanya untuk mahasiswa di prodi-nya sendiri.
        $sidangs = Sidang::with(['mahasiswa', 'pembimbing'])
            ->whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)
            ->latest()
            ->paginate(15);

        return view('kaprodi.sidang.index', compact('kaprodi', 'sidangs'));
    }

    public function sidangShow($id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        // Cegah kaprodi prodi lain mengakses pengajuan sidang di luar prodinya (IDOR).
        $sidang = Sidang::with(['mahasiswa.prodi', 'pembimbing'])
            ->whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)
            ->findOrFail($id);

        return view('kaprodi.sidang.show', compact('kaprodi', 'sidang'));
    }

    public function sidangApprove($id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $sidang = Sidang::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)
            ->findOrFail($id);

        $sidang->update([
            'kaprodi_approved' => true,
            'kaprodi_rejected' => false,
            'catatan_kaprodi'  => null,
        ]);

        return back()->with('success', 'Pengajuan Sidang Skripsi berhasil disetujui.');
    }

    public function sidangReject(Request $request, $id)
    {
        $kaprodi = $this->getKaprodi();
        if (!$kaprodi) return redirect()->route('login');

        $request->validate([
            'catatan_kaprodi' => 'required|string|max:500',
        ], [
            'catatan_kaprodi.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $sidang = Sidang::whereHas('mahasiswa', fn($q) => $q->where('prodi_id', $kaprodi->prodi_id))
            ->where('admin_verified', true)
            ->findOrFail($id);

        $sidang->update([
            'kaprodi_rejected' => true,
            'kaprodi_approved' => false,
            'catatan_kaprodi'  => $request->catatan_kaprodi,
        ]);

        return back()->with('success', 'Pengajuan Sidang Skripsi ditolak.');
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

        return view('kaprodi.profile', compact('kaprodi'));
    }
}