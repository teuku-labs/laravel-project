<?php
// FIX: file ini menggantikan app/Http/Controllers/Admin/DosenController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\User;
use App\Models\Prodi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // FIX: untuk transaksi

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $query = Dosen::with(['prodi'])
            ->withCount('mahasiswa');

        // FILTER PRODI
        if ($request->prodi_id) {
            $query->where('prodi_id', $request->prodi_id);
        }

        // FILTER STATUS
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // SEARCH
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama','like','%'.$request->search.'%')
                ->orWhere('nuptk','like','%'.$request->search.'%');
            });
        }

        $dosens = $query->paginate(10)->withQueryString();

         return view('admin.dosen.index', [
            'dosens' => $dosens,
            'prodis' => Prodi::all(),
            'totalDosen' => Dosen::count(),
            'activeCount' => Dosen::where('status','active')->count(),
            'inactiveCount' => Dosen::where('status','inactive')->count(),
            'avgMahasiswa' => Dosen::withCount('mahasiswa')->get()->avg('mahasiswa_count')
        ]);
    }

    public function create()
    {
        $prodis = Prodi::all();
        return view('admin.dosen.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required',
            'nuptk'    => 'required|unique:dosen',
            'email'    => 'required|email|unique:users',
            'prodi_id' => 'required|exists:prodi,id', // FIX: tambah exists check
        ]);

        // FIX: bungkus dalam transaksi supaya tidak ada User "yatim" kalau insert Dosen gagal
        DB::transaction(function () use ($request) {
            $user = User::create([
                'username'   => $request->nama,
                'email'      => $request->email,
                'nim_nuptk'  => $request->nuptk,
                'password'   => Hash::make('password123'),
                'role'       => 'dosen'
            ]);

            Dosen::create([
                'user_id'  => $user->id,
                'prodi_id' => $request->prodi_id,
                'nuptk'    => $request->nuptk,
                'nama'     => $request->nama
            ]);
        });

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil ditambahkan. Password default: password123');
    }

    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);

        if ($dosen->mahasiswaPembimbing1()->count() > 0 || $dosen->mahasiswaPembimbing2()->count() > 0) {
            return redirect()->back()->with('error', 'Dosen masih membimbing mahasiswa dan tidak bisa dihapus.');
        }

        $dosen->delete();

        return redirect()->back()->with('success', 'Data dosen berhasil dihapus.');
    }

    public function show($id)
    {
        $dosen = Dosen::findOrFail($id);

        return view('admin.dosen.show', compact('dosen'));
    }

    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        $prodis = Prodi::all();

        return view('admin.dosen.edit', compact('dosen','prodis'));
    }

    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'nama'  => 'required',
            'nuptk' => 'required'
        ]);

        $dosen->update([
            'nama'  => $request->nama,
            'nuptk' => $request->nuptk
        ]);

        // FIX: sebelumnya route('dosen.index') -> RouteNotFoundException (500),
        // karena resource ini didaftarkan di dalam grup name('admin.').
        return redirect()->route('admin.dosen.index')->with('success','Data dosen berhasil diperbarui');
    }
}