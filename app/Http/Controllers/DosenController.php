<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Jadwal;

class DosenController extends Controller
{
    // Helper — ambil data dosen dari user yang login
    private function getDosen()
    {
        return Dosen::where('user_id', Auth::id())->first();
    }

    // Helper — redirect kalau data dosen tidak ditemukan
    private function checkDosen()
    {
        $dosen = $this->getDosen();
        if (!$dosen) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Data dosen belum terhubung dengan akun user.']);
        }
        return $dosen;
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $dosen = $this->getDosen();
        if (!$dosen) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Data dosen belum terhubung dengan akun user.']);
        }

        $mahasiswaCount  = Mahasiswa::where('pembimbing1_id', $dosen->id)
                            ->orWhere('pembimbing2_id', $dosen->id)
                            ->count();

        $jadwals         = Jadwal::where('dosen_id', $dosen->id)->get();
        $upcomingJadwal  = $jadwals->where('tanggal', '>=', now())->count();

        $skDocuments     = $dosen->sk;
        $skCount         = $skDocuments->count();
        $pendingApproval = $skDocuments->where('status', 'pending')->count();

        return view('dosen.dashboard', compact(
            'dosen',
            'mahasiswaCount',
            'jadwals',
            'upcomingJadwal',
            'skDocuments',
            'skCount',
            'pendingApproval'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | JADWAL
    |--------------------------------------------------------------------------
    */
    public function jadwal()
    {
        $dosen = $this->getDosen();
        if (!$dosen) {
            return redirect()->route('login');
        }

        $jadwals = Jadwal::where('dosen_id', $dosen->id)
                    ->orderBy('tanggal', 'asc')
                    ->get();

        $upcomingJadwal  = $jadwals->where('tanggal', '>=', now())->count();
        $mahasiswaCount  = Mahasiswa::where('pembimbing1_id', $dosen->id)
                            ->orWhere('pembimbing2_id', $dosen->id)
                            ->count();

        return view('dosen.jadwal', compact(
            'dosen',
            'jadwals',
            'upcomingJadwal',
            'mahasiswaCount'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | MAHASISWA BIMBINGAN
    |--------------------------------------------------------------------------
    */
    public function mahasiswa()
    {
        $dosen = $this->getDosen();
        if (!$dosen) {
            return redirect()->route('login');
        }

        $mahasiswa = Mahasiswa::where('pembimbing1_id', $dosen->id)
                        ->orWhere('pembimbing2_id', $dosen->id)
                        ->get();

        $mahasiswaCount  = $mahasiswa->count();
        $upcomingJadwal  = Jadwal::where('dosen_id', $dosen->id)
                            ->where('tanggal', '>=', now())
                            ->count();

        return view('dosen.mahasiswa', compact(
            'dosen',
            'mahasiswa',
            'mahasiswaCount',
            'upcomingJadwal'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SK PEMBIMBING
    |--------------------------------------------------------------------------
    */
    public function sk()
    {
        $dosen = $this->getDosen();
        if (!$dosen) {
            return redirect()->route('login');
        }

        $skDocuments     = $dosen->sk;
        $skCount         = $skDocuments->count();
        $pendingApproval = $skDocuments->where('status', 'pending')->count();
        $mahasiswaCount  = Mahasiswa::where('pembimbing1_id', $dosen->id)
                            ->orWhere('pembimbing2_id', $dosen->id)
                            ->count();
        $upcomingJadwal  = Jadwal::where('dosen_id', $dosen->id)
                            ->where('tanggal', '>=', now())
                            ->count();

        return view('dosen.sk', compact(
            'dosen',
            'skDocuments',
            'skCount',
            'pendingApproval',
            'mahasiswaCount',
            'upcomingJadwal'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    public function profile()
    {
        $dosen = $this->getDosen();
        if (!$dosen) {
            return redirect()->route('login');
        }

        $mahasiswaCount  = Mahasiswa::where('pembimbing1_id', $dosen->id)
                            ->orWhere('pembimbing2_id', $dosen->id)
                            ->count();
        $upcomingJadwal  = Jadwal::where('dosen_id', $dosen->id)
                            ->where('tanggal', '>=', now())
                            ->count();

        return view('dosen.profile', compact(
            'dosen',
            'mahasiswaCount',
            'upcomingJadwal'
        ));
    }
}