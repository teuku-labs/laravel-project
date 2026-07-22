<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Proposal;

class ProposalController extends Controller
{
    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();

        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan. Silakan hubungi admin.');
        }

        // Syarat: sudah punya pembimbing 1 & pembimbing 2, dan sudah lulus seminar LKP
        // (sesuai alur yang ditampilkan di resources/views/mahasiswa.blade.php, tombol
        // "Daftar Proposal" baru aktif kalau pembimbing lengkap + status lkp true).
        if (empty($mahasiswa->pembimbing1_id) || empty($mahasiswa->pembimbing2_id)) {
            return back()->with('error', 'Anda harus memilih Pembimbing 1 dan Pembimbing 2 terlebih dahulu.');
        }

        if (!$mahasiswa->seminarLkp) {
            return back()->with('error', 'Anda harus menyelesaikan Seminar LKP sebelum mendaftar Seminar Proposal.');
        }

        if ($mahasiswa->proposal) {
            return back()->with('error', 'Anda sudah pernah mendaftar Seminar Proposal.');
        }

        // Nama field mengikuti form di mahasiswa.blade.php: name="judul" dan name="proposal"
        $request->validate([
            'judul'    => 'required|string|max:255',
            'proposal' => 'required|file|mimes:pdf|max:10240',
        ], [
            'judul.required'    => 'Judul skripsi wajib diisi.',
            'proposal.required' => 'File proposal wajib diupload.',
            'proposal.mimes'    => 'File proposal harus berformat PDF.',
        ]);

        $filePath = $request->file('proposal')->store('proposal', 'public');

        Proposal::create([
            'mahasiswa_id'   => $mahasiswa->id,
            'pembimbing1_id' => $mahasiswa->pembimbing1_id,
            'judul'          => $request->judul,
            'file_proposal'  => $filePath,
        ]);

        return back()->with('success', 'Pendaftaran Seminar Proposal berhasil dikirim!');
    }
}