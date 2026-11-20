<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SeminarLkp;
use App\Models\Mahasiswa;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Storage;

class SeminarLkpController extends Controller
{
    public function store(Request $request)
    {
        // ✅ Ambil data mahasiswa SEKALI saja
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();

        // ✅ Validasi: mahasiswa harus ada dan sudah pilih pembimbing
        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan. Silakan hubungi admin.');
        }

        if (empty($mahasiswa->pembimbing_lkp_id)) {
            return back()->with('error', 'Anda belum memilih dosen pembimbing LKP!');
        }

        // ✅ Validasi: cegah daftar dua kali
        $sudahDaftar = SeminarLkp::where('mahasiswa_id', $mahasiswa->id)->exists();
        if ($sudahDaftar) {
            return back()->with('error', 'Anda sudah pernah mendaftar seminar LKP.');
        }

        // Validasi semua input (teks + file) di sisi server
        $request->validate([
            'no_hp'          => ['required', 'regex:/^(\+62|62|0)8[0-9]{8,12}$/'],
            'nik_ktp'        => 'required|digits:16',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date|before:today',
            'judul_lkp'      => 'required|string|max:255',
            'laporan_lkp'    => 'required|file|mimes:pdf|max:10240',
            'bukti_transfer' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'no_hp.required'          => 'Nomor HP wajib diisi.',
            'no_hp.regex'             => 'Format nomor HP tidak valid (contoh: 081234567890).',
            'nik_ktp.required'        => 'NIK wajib diisi.',
            'nik_ktp.digits'          => 'NIK harus 16 digit angka.',
            'tempat_lahir.required'   => 'Tempat lahir wajib diisi.',
            'tempat_lahir.max'        => 'Tempat lahir maksimal 100 karakter.',
            'tanggal_lahir.required'  => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'      => 'Tanggal lahir tidak valid.',
            'tanggal_lahir.before'    => 'Tanggal lahir harus sebelum hari ini.',
            'judul_lkp.required'      => 'Judul LKP wajib diisi.',
            'judul_lkp.max'           => 'Judul LKP maksimal 255 karakter.',
            'laporan_lkp.required'    => 'File laporan LKP wajib diupload.',
            'laporan_lkp.mimes'       => 'Laporan LKP harus berformat PDF.',
            'laporan_lkp.max'         => 'Ukuran laporan LKP maksimal 10 MB.',
            'bukti_transfer.required' => 'Bukti transfer wajib diupload.',
            'bukti_transfer.mimes'    => 'Bukti transfer harus berformat PDF, JPG, atau PNG.',
            'bukti_transfer.max'      => 'Ukuran bukti transfer maksimal 5 MB.',
        ]);

        // Simpan file
        $laporan = $request->file('laporan_lkp')->store('laporan', 'public');
        $bukti   = $request->file('bukti_transfer')->store('bukti', 'public');

        // Simpan pendaftaran. Jika gagal (termasuk klik ganda yang lolos
        // pengecekan di atas), file yang sudah terupload dihapus kembali.
        try {
            SeminarLkp::create([
                'mahasiswa_id'   => $mahasiswa->id,
                'email'          => Auth::user()->email,
                'nik_ktp'        => $request->nik_ktp,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'no_hp'          => $request->no_hp,
                'judul_lkp'      => $request->judul_lkp,
                'pembimbing1_id' => $mahasiswa->pembimbing_lkp_id,
                'file_laporan'   => $laporan,
                'bukti_transfer' => $bukti,
            ]);
        } catch (UniqueConstraintViolationException $e) {
            Storage::disk('public')->delete([$laporan, $bukti]);
            return back()->with('error', 'Anda sudah pernah mendaftar seminar LKP.');
        } catch (\Throwable $e) {
            Storage::disk('public')->delete([$laporan, $bukti]);
            throw $e;
        }

        return back()->with('success', 'Pendaftaran seminar LKP berhasil dikirim!');
    }
}