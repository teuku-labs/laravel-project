<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Sidang;

class SidangController extends Controller
{
    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();

        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan. Silakan hubungi admin.');
        }

        // Syarat: sesuai tampilan mahasiswa.blade.php, tombol "Daftar Sidang" baru
        // aktif kalau Seminar Proposal sudah didaftarkan.
        $proposal = $mahasiswa->proposal;
        if (!$proposal) {
            return back()->with('error', 'Anda harus menyelesaikan Seminar Proposal sebelum mendaftar Sidang Skripsi.');
        }

        if ($mahasiswa->sidang) {
            return back()->with('error', 'Anda sudah pernah mendaftar Sidang Skripsi.');
        }

        // Nama field mengikuti form di mahasiswa.blade.php: name="skripsi" dan name="bebas_pustaka"
        $request->validate([
            'skripsi'       => 'required|file|mimes:pdf|max:10240',
            'bebas_pustaka' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'skripsi.required'       => 'File skripsi lengkap wajib diupload.',
            'skripsi.mimes'          => 'File skripsi harus berformat PDF.',
            'bebas_pustaka.required' => 'Surat bebas pustaka wajib diupload.',
        ]);

        $fileSkripsi      = $request->file('skripsi')->store('sidang/skripsi', 'public');
        $fileBebasPustaka = $request->file('bebas_pustaka')->store('sidang/bebas-pustaka', 'public');

        Sidang::create([
            'mahasiswa_id'       => $mahasiswa->id,
            // Judul diambil dari Seminar Proposal yang sudah disetujui, bukan diinput
            // ulang, supaya tidak ada perbedaan judul antara proposal & sidang.
            'judul_skripsi'      => $proposal->judul,
            'pembimbing_id'      => $mahasiswa->pembimbing1_id,
            'file_draft'         => $fileSkripsi,
            'file_bebas_pustaka' => $fileBebasPustaka,
        ]);

        return back()->with('success', 'Pendaftaran Sidang Skripsi berhasil dikirim!');
    }
}
