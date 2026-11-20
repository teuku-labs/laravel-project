<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\UniqueConstraintViolationException;
use App\Models\Mahasiswa;
use App\Models\Proposal;

class ProposalController extends Controller
{
    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::with('seminarLkp.nilai')->where('user_id', Auth::id())->first();

        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan. Silakan hubungi admin.');
        }

        // Syarat 1: sudah punya pembimbing 1 & pembimbing 2
        if (empty($mahasiswa->pembimbing1_id) || empty($mahasiswa->pembimbing2_id)) {
            return back()->with('error', 'Anda harus memilih Pembimbing 1 dan Pembimbing 2 terlebih dahulu.');
        }

        // Syarat 2: Seminar LKP sudah dinyatakan LULUS
        // (nilai sudah diinput oleh dosen dan bukan E / rata-rata minimal 50).
        $lkp = $mahasiswa->seminarLkp;
        if (!$lkp) {
            return back()->with('error', 'Anda harus mendaftar dan lulus Seminar LKP sebelum mendaftar Seminar Proposal.');
        }
        if (!$lkp->lulus()) {
            return back()->with('error', 'Seminar LKP Anda belum dinyatakan lulus. Nilai LKP harus sudah diinput oleh dosen dan bukan E.');
        }

        // Syarat 3: belum pernah mendaftar proposal
        if ($mahasiswa->proposal) {
            return back()->with('error', 'Anda sudah pernah mendaftar Seminar Proposal.');
        }

        // Nama field mengikuti form di mahasiswa.blade.php: name="judul" dan name="proposal"
        $request->validate([
            'judul'    => 'required|string|max:255',
            'proposal' => 'required|file|mimes:pdf|max:10240',
        ], [
            'judul.required'    => 'Judul skripsi wajib diisi.',
            'judul.max'         => 'Judul skripsi maksimal 255 karakter.',
            'proposal.required' => 'File proposal wajib diupload.',
            'proposal.file'     => 'File proposal tidak valid.',
            'proposal.mimes'    => 'File proposal harus berformat PDF.',
            'proposal.max'      => 'Ukuran file proposal maksimal 10 MB.',
        ]);

        $filePath = $request->file('proposal')->store('proposal', 'public');

        // Jika penyimpanan gagal (termasuk klik ganda yang lolos pengecekan di atas),
        // file yang sudah terupload dihapus kembali agar tidak jadi file yatim.
        try {
            Proposal::create([
                'mahasiswa_id'   => $mahasiswa->id,
                'pembimbing1_id' => $mahasiswa->pembimbing1_id,
                'judul'          => $request->judul,
                'file_proposal'  => $filePath,
                // Tanpa verifikasi admin: data langsung masuk ke Kaprodi
                // untuk penentuan jadwal dan dosen pembahas/penguji.
                'admin_verified' => true,
            ]);
        } catch (UniqueConstraintViolationException $e) {
            Storage::disk('public')->delete($filePath);
            return back()->with('error', 'Anda sudah pernah mendaftar Seminar Proposal.');
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($filePath);
            throw $e;
        }

        return back()->with('success', 'Pendaftaran Seminar Proposal berhasil dikirim!');
    }
}