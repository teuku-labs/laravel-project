<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

        // Syarat: Seminar Proposal harus sudah didaftarkan DAN dinyatakan lulus
        // (nilai sudah diinput dan bukan E), sama seperti aturan Seminar LKP -> Proposal.
        $proposal = $mahasiswa->proposal;
        if (!$proposal) {
            return back()->with('error', 'Anda harus menyelesaikan Seminar Proposal sebelum mendaftar Sidang Skripsi.');
        }

        if (!$proposal->lulus()) {
            return back()->with('error', 'Seminar Proposal Anda belum dinyatakan lulus. Sidang Skripsi bisa didaftar setelah nilai proposal keluar dan lulus.');
        }

        // Pendaftaran yang sudah ada: hanya boleh dikirim ulang kalau DITOLAK kaprodi.
        $sidangLama = $mahasiswa->sidang;
        if ($sidangLama && !$sidangLama->kaprodi_rejected) {
            return back()->with('error', 'Anda sudah pernah mendaftar Sidang Skripsi.');
        }

        // Nama field mengikuti form di mahasiswa.blade.php: name="skripsi" dan name="bebas_pustaka"
        $request->validate([
            'skripsi'       => 'required|file|mimes:pdf|max:10240',
            'bebas_pustaka' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'skripsi.required'       => 'File skripsi lengkap wajib diupload.',
            'skripsi.mimes'          => 'File skripsi harus berformat PDF.',
            'bebas_pustaka.required' => 'Foto pengesahan untuk sidang skripsi wajib diupload.',
        ]);

        $fileSkripsi      = $request->file('skripsi')->store('sidang/skripsi', 'public');
        $fileBebasPustaka = $request->file('bebas_pustaka')->store('sidang/pengesahan', 'public');

        // ---- Kirim ulang setelah ditolak kaprodi ----
        if ($sidangLama) {
            // Hapus berkas lama supaya tidak menumpuk di storage
            foreach ([$sidangLama->file_draft, $sidangLama->file_bebas_pustaka] as $berkasLama) {
                if ($berkasLama) {
                    Storage::disk('public')->delete($berkasLama);
                }
            }

            // Reset status supaya kaprodi bisa memutuskan ulang dari awal.
            $sidangLama->update([
                'judul_skripsi'      => $proposal->judul,
                'pembimbing_id'      => $mahasiswa->pembimbing1_id,
                // Pembahas ikut pembahas seminar proposal; kalau kaprodi sudah pernah
                // mengubahnya, pilihan kaprodi tidak ditimpa.
                'penguji1_id'        => $sidangLama->penguji1_id ?? $proposal->penguji1_id,
                'penguji2_id'        => $sidangLama->penguji2_id ?? $proposal->penguji2_id,
                'file_draft'         => $fileSkripsi,
                'file_bebas_pustaka' => $fileBebasPustaka,
                // Tanpa verifikasi admin: langsung masuk ke kaprodi
                'admin_verified'     => true,
                'kaprodi_approved'   => false,
                'kaprodi_rejected'   => false,
                'catatan_kaprodi'    => null,
            ]);

            return back()->with('success', 'Berkas Sidang Skripsi berhasil dikirim ulang!');
        }

        // ---- Pendaftaran pertama ----
        try {
            Sidang::create([
                'mahasiswa_id'       => $mahasiswa->id,
                // Judul diambil dari Seminar Proposal yang sudah disetujui, bukan diinput
                // ulang, supaya tidak ada perbedaan judul antara proposal & sidang.
                'judul_skripsi'      => $proposal->judul,
                'pembimbing_id'      => $mahasiswa->pembimbing1_id,
                // Dosen pembahas sidang otomatis sama dengan pembahas seminar proposal.
                // Setelah ini hanya kaprodi yang bisa mengubahnya.
                'penguji1_id'        => $proposal->penguji1_id,
                'penguji2_id'        => $proposal->penguji2_id,
                'file_draft'         => $fileSkripsi,
                'file_bebas_pustaka' => $fileBebasPustaka,
                // Tanpa verifikasi admin: langsung masuk ke kaprodi
                'admin_verified'     => true,
            ]);
        } catch (UniqueConstraintViolationException $e) {
            // Klik ganda / dua request bersamaan: constraint unique di DB menahan duplikat.
            Storage::disk('public')->delete([$fileSkripsi, $fileBebasPustaka]);

            return back()->with('error', 'Anda sudah pernah mendaftar Sidang Skripsi.');
        }

        return back()->with('success', 'Pendaftaran Sidang Skripsi berhasil dikirim!');
    }
}