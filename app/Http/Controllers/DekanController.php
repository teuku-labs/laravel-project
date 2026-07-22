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

class DekanController extends Controller
{
    private function getDekan()
    {
        return Dekan::where('user_id', Auth::id())->first();
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

        $totalMahasiswa  = Mahasiswa::count();
        $totalSeminar    = SeminarLkp::count();
        $sudahDijadwal   = Jadwal::where('jenis', 'lkp')->count();
        $belumDijadwal   = SeminarLkp::whereNull('tanggal_seminar')->count();

        $jadwalTerbaru = Jadwal::with(['mahasiswa', 'dosen'])
                            ->where('jenis', 'lkp')
                            ->orderBy('tanggal', 'asc')
                            ->take(10)
                            ->get();

        return view('dekan.dashboard', compact(
            'dekan',
            'totalMahasiswa',
            'totalSeminar',
            'sudahDijadwal',
            'belumDijadwal',
            'jadwalTerbaru'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SEMUA JADWAL SEMINAR
    |--------------------------------------------------------------------------
    */
    public function jadwal()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $jadwalList = Jadwal::with(['mahasiswa', 'dosen'])
                        ->orderBy('tanggal', 'asc')
                        ->get();

        return view('dekan.jadwal', compact('dekan', 'jadwalList'));
    }

    /*
    |--------------------------------------------------------------------------
    | SEMUA PENDAFTAR SEMINAR LKP
    |--------------------------------------------------------------------------
    */
    public function seminar()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $seminarList = SeminarLkp::with(['mahasiswa', 'dosen'])
                        ->latest()
                        ->get();

        return view('dekan.seminar', compact('dekan', 'seminarList'));
    }

    /*
    |--------------------------------------------------------------------------
    | SEMUA PENGAJUAN PROPOSAL
    |--------------------------------------------------------------------------
    */
    public function proposal()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $proposalList = Proposal::with(['mahasiswa.prodi', 'pembimbing1'])
                        ->latest()
                        ->get();

        return view('dekan.proposal', compact('dekan', 'proposalList'));
    }

    /*
    |--------------------------------------------------------------------------
    | SEMUA PENGAJUAN SIDANG
    |--------------------------------------------------------------------------
    */
    public function sidang()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $sidangList = Sidang::with(['mahasiswa.prodi', 'pembimbing'])
                        ->latest()
                        ->get();

        return view('dekan.sidang', compact('dekan', 'sidangList'));
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

        return view('dekan.profile', compact('dekan'));
    }
}