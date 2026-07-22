<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // FIX: untuk transaksi

class RegisterController extends Controller
{

    public function index()
    {
        $prodis = Prodi::all();

        return view('register', compact('prodis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // FIX: tambah pengecekan unique ke tabel users.nim_nuptk juga (kolom itu unik di DB),
            // sebelumnya hanya dicek ke mahasiswa.nim sehingga bisa lolos validasi lalu meledak
            // jadi SQL error mentah saat insert.
            'nim_nuptk' => 'required|max:16|unique:mahasiswa,nim|unique:users,nim_nuptk',
            'nama'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            // FIX: pastikan prodi_id yang dikirim benar-benar ada di tabel prodi
            'prodi_id'  => 'required|exists:prodi,id',
            'angkatan'  => 'required|digits:4',
            'password'  => 'required|min:8', // FIX: dinaikkan dari min:6 ke min:8
        ], [
            'nim_nuptk.unique' => 'NIM sudah terdaftar.',
            'email.unique'     => 'Email sudah digunakan.',
            'prodi_id.exists'  => 'Program studi tidak valid.',
        ]);

        // FIX: bungkus dalam transaksi supaya tidak ada User "yatim" tanpa data Mahasiswa
        // kalau salah satu insert gagal.
        DB::transaction(function () use ($request) {
            $user = User::create([
                'username'  => $request->nama,
                'nim_nuptk' => $request->nim_nuptk,
                'email'     => $request->email,
                'role'      => 'mahasiswa',
                'password'  => Hash::make($request->password),
            ]);

            Mahasiswa::create([
                'user_id'  => $user->id,
                'nim'      => $request->nim_nuptk,
                'nama'     => $request->nama,
                'prodi_id' => $request->prodi_id,
                'angkatan' => $request->angkatan,
            ]);
        });

        // FIX: withInput() dihapus — sebelumnya ini menyimpan password mentah
        // ke session flash data walau statusnya sukses, tidak diperlukan sama sekali.
        return redirect('/')->with('success', 'Register berhasil, silakan login');
    }
}