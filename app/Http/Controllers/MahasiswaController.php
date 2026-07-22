<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\SeminarLkp;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Ambil data mahasiswa
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->firstOrFail();

        // Ambil dosen sesuai prodi mahasiswa
        $dosens = Dosen::where('prodi_id', $mahasiswa->prodi_id ?? null)->get();

        // ✅ Kumpulkan pembimbing yang sudah dipilih (untuk cek di view)
        $pembimbing = array_filter([
            $mahasiswa->pembimbing1_id,
            $mahasiswa->pembimbing2_id,
        ]);

        // ✅ Ambil record pendaftaran (bukan cuma exists()) supaya view bisa
        // menampilkan jadwal & status verifikasi/persetujuan ke mahasiswa.
        $lkp      = SeminarLkp::where('mahasiswa_id', $mahasiswa->id)->first();
        $proposal = $mahasiswa->proposal;
        $sidang   = $mahasiswa->sidang;

        $status = [
            'lkp'      => (bool) $lkp,
            'proposal' => (bool) $proposal,
            'sidang'   => (bool) $sidang,
        ];

        return view('mahasiswa', compact(
            'mahasiswa',
            'dosens',
            'pembimbing',
            'status',
            'lkp',
            'proposal',
            'sidang'
        ));
    }

    public function profile()
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();

        return view('mahasiswa.profile', [
            'mahasiswa' => $mahasiswa,
            'user'      => Auth::user(),
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.min'          => 'Password baru minimal 8 karakter.',
            'new_password.confirmed'    => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        Auth::user()->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password berhasil diubah.');
    }

    public function pilihDosen(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'jenis'    => 'required|in:pembimbing1,pembimbing2',
        ]);

        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();

        if ($request->jenis === 'pembimbing1') {
            // Cegah pilih dosen yang sama dengan pembimbing2
            if ($mahasiswa->pembimbing2_id == $request->dosen_id) {
                return back()->with('error', 'Dosen ini sudah dipilih sebagai Pembimbing 2.');
            }
            $mahasiswa->pembimbing1_id = $request->dosen_id;

        } elseif ($request->jenis === 'pembimbing2') {
            // Cegah pilih dosen yang sama dengan pembimbing1
            if ($mahasiswa->pembimbing1_id == $request->dosen_id) {
                return back()->with('error', 'Dosen ini sudah dipilih sebagai Pembimbing 1.');
            }
            $mahasiswa->pembimbing2_id = $request->dosen_id;
        }

        $mahasiswa->save();

        return back()->with('success', 'Dosen pembimbing berhasil dipilih.');
    }

    public function pilihDosenLkp(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
        ]);

        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();

        // Cegah ganti dosen LKP kalau sudah daftar seminar
        $sudahDaftar = SeminarLkp::where('mahasiswa_id', $mahasiswa->id)->exists();
        if ($sudahDaftar) {
            return back()->with('error', 'Tidak bisa ganti dosen LKP karena sudah mendaftar seminar.');
        }

        $mahasiswa->pembimbing_lkp_id = $request->dosen_id;
        $mahasiswa->save();

        return back()->with('success', 'Dosen pembimbing LKP berhasil dipilih.');
    }
}