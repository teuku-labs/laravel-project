<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SeminarLkp;
use App\Models\Mahasiswa;

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

        // ✅ Validasi file
        $request->validate([
            'laporan_lkp'    => 'required|file|mimes:pdf|max:10240',
            'bukti_transfer' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'laporan_lkp.required'    => 'File laporan LKP wajib diupload.',
            'laporan_lkp.mimes'       => 'Laporan LKP harus berformat PDF.',
            'bukti_transfer.required' => 'Bukti transfer wajib diupload.',
            'bukti_transfer.mimes'    => 'Bukti transfer harus berformat PDF, JPG, atau PNG.',
        ]);

        // ✅ Simpan file
        $laporan = $request->file('laporan_lkp')->store('laporan', 'public');
        $bukti   = $request->file('bukti_transfer')->store('bukti', 'public');

        // ✅ Simpan pendaftaran — mahasiswa_id pakai $mahasiswa->id bukan Auth::id()
        SeminarLkp::create([
            'mahasiswa_id'   => $mahasiswa->id,           // ✅ BENAR: ID tabel mahasiswa
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

        return back()->with('success', 'Pendaftaran seminar LKP berhasil dikirim!');
    }
}