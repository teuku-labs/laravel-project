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
            'pembimbingLkp', 'seminarLkp.dosen', 'seminarLkp.nilai',
            'proposal.nilai', 'sidang', 'pengajuanSk',
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
            'lkp_lulus' => $lkp ? $lkp->lulus() : false,
            'proposal' => (bool) $proposal,
            'proposal_lulus' => $proposal ? $proposal->lulus() : false,
            'sidang'   => (bool) $sidang,
            // Sidang ditolak kaprodi -> mahasiswa boleh mengirim ulang berkas
            'sidang_ditolak' => $sidang ? (bool) $sidang->kaprodi_rejected : false,
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

        $pengajuanLama = PengajuanSk::where('mahasiswa_id', $mahasiswa->id)->first();

        if ($pengajuanLama) {
            // Hanya pengajuan yang ditolak kaprodi yang boleh diajukan ulang
            if (!$pengajuanLama->kaprodi_rejected) {
                return back()->with('error', 'SK Pembimbing sudah pernah diajukan.');
            }

            $pengajuanLama->update([
                'pembimbing1_id'   => $mahasiswa->pembimbing1_id,
                'pembimbing2_id'   => $mahasiswa->pembimbing2_id,
                'admin_verified'   => true,
                'kaprodi_approved' => false,
                'kaprodi_rejected' => false,
                'catatan_kaprodi'  => null,
            ]);

            return back()->with('success', 'Pengajuan SK Pembimbing berhasil dikirim ulang!');
        }

        PengajuanSk::create([
            'mahasiswa_id'     => $mahasiswa->id,
            'pembimbing1_id'   => $mahasiswa->pembimbing1_id,
            'pembimbing2_id'   => $mahasiswa->pembimbing2_id,
            // Tanpa verifikasi admin: langsung masuk ke kaprodi
            'admin_verified'   => true,
            'kaprodi_approved' => false,
            'kaprodi_rejected' => false,
        ]);

        return back()->with('success', 'Pengajuan SK Pembimbing berhasil dikirim!');
    }

    /*
    |--------------------------------------------------------------------------
    | Lihat & unduh SK Pembimbing milik sendiri
    |--------------------------------------------------------------------------
    */
    public function skShow()
    {
        $user      = Auth::user();
        $mahasiswa = Mahasiswa::with(['prodi', 'pembimbing1', 'pembimbing2', 'seminarLkp', 'proposal', 'pengajuanSk'])
            ->where('user_id', $user->id)->firstOrFail();

        $sk = $mahasiswa->pengajuanSk;
        if (!$sk) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Anda belum mengajukan SK Pembimbing.');
        }

        return view('mahasiswa.sk', compact('mahasiswa', 'sk'));
    }

    public function skUnduh()
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();
        $sk = $mahasiswa->pengajuanSk;

        // Hanya SK milik sendiri yang sudah disetujui kaprodi dan diterbitkan dekan
        if (!$sk || !$sk->kaprodi_approved || !$sk->sudahTerbit()) {
            return redirect()->route('sk.show')
                ->with('error', 'SK Pembimbing belum diterbitkan, jadi belum bisa diunduh.');
        }

        $kurang = $sk->kekuranganData();
        if ($kurang) {
            return redirect()->route('sk.show')
                ->with('error', 'SK belum bisa diunduh, data belum lengkap: ' . implode(', ', $kurang) . '.');
        }

        try {
            $file = $sk->buatFileSk();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('sk.show')->with('error', 'Gagal membuat file SK, silakan coba lagi.');
        }

        return response()
            ->download($file, $sk->namaFileSk(), [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ])
            ->deleteFileAfterSend(true);
    }
}