<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\SeminarLkp;
use App\Models\PengajuanSk;
use App\Models\PengajuanPembimbing;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $user      = Auth::user();
        $mahasiswa = Mahasiswa::with([
            'prodi', 'pembimbing1', 'pembimbing2',
            'pembimbingLkp', 'seminarLkp.dosen',
            'proposal', 'sidang', 'pengajuanSk',
            'pengajuanPembimbing.dosen',
        ])->where('user_id', $user->id)->firstOrFail();

        $dosens = Dosen::where('prodi_id', $mahasiswa->prodi_id ?? null)->get();

        $pembimbing = array_filter([
            $mahasiswa->pembimbing1_id,
            $mahasiswa->pembimbing2_id,
        ]);

        // Data pendaftaran (dipakai view untuk menampilkan jadwal & status verifikasi)
        $lkp      = $mahasiswa->seminarLkp;
        $proposal = $mahasiswa->proposal;
        $sidang   = $mahasiswa->sidang;

        // Status pendaftaran
        $status = [
            'lkp'      => (bool) $lkp,
            'proposal' => (bool) $proposal,
            'sidang'   => (bool) $sidang,
        ];

        // Status pengajuan pembimbing yang sedang pending
        // (hanya tampilkan untuk slot yang belum terisi, supaya notifikasi lama
        //  tidak terus muncul setelah pembimbing untuk slot itu sudah didapat)
        $slotTerisi = function ($jenis) use ($mahasiswa) {
            return $jenis === 'pembimbing1'
                ? (bool) $mahasiswa->pembimbing1_id
                : (bool) $mahasiswa->pembimbing2_id;
        };

        $pengajuanPending = $mahasiswa->pengajuanPembimbing
            ->where('status', 'pending')
            ->reject(fn($p) => $slotTerisi($p->catatan));

        $pengajuanApproved = $mahasiswa->pengajuanPembimbing
            ->where('status', 'approved');

        $pengajuanRejected = $mahasiswa->pengajuanPembimbing
            ->where('status', 'rejected')
            ->reject(fn($p) => $slotTerisi($p->catatan));

        return view('mahasiswa', compact(
            'mahasiswa', 'dosens', 'pembimbing', 'status',
            'pengajuanPending', 'pengajuanApproved', 'pengajuanRejected',
            'lkp', 'proposal', 'sidang'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Pilih Dosen Pembimbing — sekarang membuat PENGAJUAN, bukan langsung set
    |--------------------------------------------------------------------------
    */
    public function pilihDosen(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'jenis'    => 'required|in:pembimbing1,pembimbing2',
        ]);

        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();

        // Kalau sudah punya pembimbing sesuai jenis, tidak bisa ganti
        if ($request->jenis === 'pembimbing1' && $mahasiswa->pembimbing1_id) {
            return back()->with('error', 'Pembimbing 1 sudah ditetapkan dan tidak bisa diubah.');
        }
        if ($request->jenis === 'pembimbing2' && $mahasiswa->pembimbing2_id) {
            return back()->with('error', 'Pembimbing 2 sudah ditetapkan dan tidak bisa diubah.');
        }

        // Cegah pilih dosen yang sama
        if ($request->jenis === 'pembimbing1' && $mahasiswa->pembimbing2_id == $request->dosen_id) {
            return back()->with('error', 'Dosen ini sudah dipilih sebagai Pembimbing 2.');
        }
        if ($request->jenis === 'pembimbing2' && $mahasiswa->pembimbing1_id == $request->dosen_id) {
            return back()->with('error', 'Dosen ini sudah dipilih sebagai Pembimbing 1.');
        }

        // Cegah kirim pengajuan duplikat ke dosen yang sama
        $sudahAda = PengajuanPembimbing::where('mahasiswa_id', $mahasiswa->id)
            ->where('dosen_id', $request->dosen_id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Pengajuan ke dosen ini sudah ada atau sudah disetujui.');
        }

        // Buat pengajuan
        PengajuanPembimbing::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_id'     => $request->dosen_id,
            'status'       => 'pending',
            'catatan'      => $request->jenis, // simpan jenis (pembimbing1/2) di kolom catatan
        ]);

        $dosen = Dosen::find($request->dosen_id);
        return back()->with('success',
            'Permintaan bimbingan ke ' . $dosen->nama . ' berhasil dikirim. Menunggu persetujuan dosen.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Pilih Dosen Pembimbing LKP — tetap langsung (tidak perlu approval)
    |--------------------------------------------------------------------------
    */
    public function pilihDosenLkp(Request $request)
    {
        $request->validate(['dosen_id' => 'required|exists:dosen,id']);

        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();

        if (SeminarLkp::where('mahasiswa_id', $mahasiswa->id)->exists()) {
            return back()->with('error', 'Tidak bisa ganti dosen LKP karena sudah mendaftar seminar.');
        }

        $mahasiswa->pembimbing_lkp_id = $request->dosen_id;
        $mahasiswa->save();

        return back()->with('success', 'Dosen pembimbing LKP berhasil dipilih.');
    }

    /*
    |--------------------------------------------------------------------------
    | Ajukan SK Pembimbing
    |--------------------------------------------------------------------------
    */
    public function ajukanSk()
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();

        if (!$mahasiswa->pembimbing1_id || !$mahasiswa->pembimbing2_id) {
            return back()->with('error', 'Kedua dosen pembimbing harus sudah menyetujui bimbingan terlebih dahulu.');
        }

        if (PengajuanSk::where('mahasiswa_id', $mahasiswa->id)->exists()) {
            return back()->with('error', 'SK Pembimbing sudah pernah diajukan.');
        }

        PengajuanSk::create([
            'mahasiswa_id'     => $mahasiswa->id,
            'pembimbing1_id'   => $mahasiswa->pembimbing1_id,
            'pembimbing2_id'   => $mahasiswa->pembimbing2_id,
            'admin_verified'   => false,
            'kaprodi_approved' => false,
            'kaprodi_rejected' => false,
        ]);

        return back()->with('success', 'Pengajuan SK Pembimbing berhasil dikirim!');
    }
}