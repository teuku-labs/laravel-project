<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dekan;
use App\Models\SeminarLkp;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\Proposal;
use App\Models\Sidang;
use App\Models\PengajuanPembimbing;

class DekanController extends Controller
{
    /**
     * Ambil data dekan yang sedang login beserta relasinya.
     * PERBAIKAN: Menambahkan ->with(['user', 'prodi']) untuk eager loading
     * agar data relasi pasti ter-load dan tidak null di Blade.
     */
    private function getDekan()
    {
        return Dekan::with(['user', 'prodi'])
                    ->where('user_id', Auth::id())
                    ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $dekan = $this->getDekan();
        if (!$dekan) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Data Dekan tidak ditemukan.']);
        }

        $totalMahasiswa = Mahasiswa::count();
        $totalSeminar   = SeminarLkp::count();
        $sudahDijadwal  = Jadwal::where('jenis', 'lkp')->count();
        $belumDijadwal  = SeminarLkp::whereNull('tanggal_seminar')->count();

        $jadwalTerbaru = Jadwal::with(['mahasiswa', 'dosen'])
                            ->where('jenis', 'lkp')
                            ->orderBy('tanggal', 'asc')
                            ->take(5)->get();

        // ✅ Fitur Dosen Pembimbing
        $pengajuanBimbingan = PengajuanPembimbing::where('dosen_id', $dekan->user_id)
                                ->where('status', 'pending')
                                ->with('mahasiswa.prodi')->get();

        $mahasiswaBimbingan = Mahasiswa::where('pembimbing1_id', $dekan->user_id)
                                ->orWhere('pembimbing2_id', $dekan->user_id)->count();

        return view('dekan.dashboard', compact(
            'dekan', 'totalMahasiswa', 'totalSeminar',
            'sudahDijadwal', 'belumDijadwal', 'jadwalTerbaru',
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
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $seminarList = SeminarLkp::with(['mahasiswa', 'dosen'])->latest()->get();
        return view('dekan.seminar', compact('dekan', 'seminarList'));
    }

    /*
    |--------------------------------------------------------------------------
    | JADWAL SEMINAR
    |--------------------------------------------------------------------------
    */
    public function jadwal()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $jadwalList = Jadwal::with(['mahasiswa', 'dosen'])->orderBy('tanggal', 'asc')->get();
        return view('dekan.jadwal', compact('dekan', 'jadwalList'));
    }

    /*
    |--------------------------------------------------------------------------
    | PROPOSAL
    |--------------------------------------------------------------------------
    */
    public function proposal()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $proposalList = Proposal::with(['mahasiswa.prodi', 'pembimbing1'])->latest()->get();
        return view('dekan.proposal', compact('dekan', 'proposalList'));
    }

    /*
    |--------------------------------------------------------------------------
    | SIDANG
    |--------------------------------------------------------------------------
    */
    public function sidang()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $sidangList = Sidang::with(['mahasiswa.prodi', 'pembimbing'])->latest()->get();
        return view('dekan.sidang', compact('dekan', 'sidangList'));
    }

    /*
    |--------------------------------------------------------------------------
    | ✅ FITUR DOSEN PEMBIMBING — Pengajuan Bimbingan
    |--------------------------------------------------------------------------
    */
    public function bimbinganIndex()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $pengajuanPending = PengajuanPembimbing::where('dosen_id', $dekan->user_id)
                            ->where('status', 'pending')
                            ->with('mahasiswa.prodi')->latest()->get();

        $riwayatPengajuan = PengajuanPembimbing::where('dosen_id', $dekan->user_id)
                            ->whereIn('status', ['approved', 'rejected'])
                            ->with('mahasiswa.prodi')->latest()->get();

        $mahasiswaBimbingan = Mahasiswa::where('pembimbing1_id', $dekan->user_id)
                                ->orWhere('pembimbing2_id', $dekan->user_id)
                                ->with('prodi')->get();

        $mahasiswaCount = $mahasiswaBimbingan->count();

        return view('dekan.bimbingan', compact(
            'dekan', 'pengajuanPending', 'riwayatPengajuan',
            'mahasiswaBimbingan', 'mahasiswaCount'
        ));
    }

    public function bimbinganApprove($id)
    {
        $dekan     = $this->getDekan();
        $pengajuan = PengajuanPembimbing::where('id', $id)
                        ->where('dosen_id', $dekan->user_id)->firstOrFail();

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $mahasiswa = $pengajuan->mahasiswa;
        $jenis     = explode('|', $pengajuan->catatan)[0];

        if ($jenis === 'pembimbing1') {
            $mahasiswa->pembimbing1_id = $dekan->user_id;
        } else {
            $mahasiswa->pembimbing2_id = $dekan->user_id;
        }
        $mahasiswa->save();

        $pengajuan->update(['status' => 'approved']);

        PengajuanPembimbing::where('mahasiswa_id', $mahasiswa->id)
            ->where('id', '!=', $id)
            ->where('catatan', 'like', $jenis . '%')
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);

        return back()->with('success', 'Permintaan bimbingan dari ' . $mahasiswa->nama . ' disetujui.');
    }

    public function bimbinganReject(Request $request, $id)
    {
        $dekan     = $this->getDekan();
        $pengajuan = PengajuanPembimbing::where('id', $id)
                        ->where('dosen_id', $dekan->user_id)->firstOrFail();

        $jenis  = explode('|', $pengajuan->catatan)[0];
        $alasan = $request->alasan ?: 'Tidak ada alasan';

        $pengajuan->update(['status' => 'rejected', 'catatan' => $jenis . '|' . $alasan]);
        return back()->with('success', 'Permintaan bimbingan ditolak.');
    }

    /*
    |--------------------------------------------------------------------------
    | ✅ JADWAL SAYA (sebagai pembimbing)
    |--------------------------------------------------------------------------
    */
    public function jadwalSaya()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $jadwals = Jadwal::where('dosen_id', $dekan->user_id)
                    ->with('mahasiswa')->orderBy('tanggal', 'asc')->get();

        return view('dekan.jadwal-saya', compact('dekan', 'jadwals'));
    }

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    public function profile()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $mahasiswaBimbingan = Mahasiswa::where('pembimbing1_id', $dekan->user_id)
                                ->orWhere('pembimbing2_id', $dekan->user_id)->count();
        $pengajuanBaru      = PengajuanPembimbing::where('dosen_id', $dekan->user_id)
                                ->where('status', 'pending')->count();

        return view('dekan.profile', compact('dekan', 'mahasiswaBimbingan', 'pengajuanBaru'));
    }
}