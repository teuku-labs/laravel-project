@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-title">
        <i class="fas fa-user"></i>
        <span>Detail Dosen</span>
    </div>
    <div style="display:flex;gap:.75rem;">
        <a href="{{ route('admin.dosen.edit', $dosen->id) }}" class="btn btn-primary-custom" style="padding:.65rem 1.25rem;">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.dosen.index') }}" class="btn" style="background:#eee;color:#333;padding:.65rem 1.25rem;border-radius:10px;text-decoration:none;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div style="display:grid;grid-template-columns:300px 1fr;gap:1.5rem;align-items:start;">

    {{-- Profil Card --}}
    <div class="table-card" style="text-align:center;">
        <div style="width:90px;height:90px;background:linear-gradient(135deg,var(--primary-green),var(--dark-green));border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:2.5rem;font-weight:700;margin:0 auto 1rem;">
            {{ substr($dosen->nama, 0, 1) }}
        </div>
        <h5 style="font-weight:700;margin-bottom:.25rem;">{{ $dosen->nama }}</h5>
        <p style="color:var(--text-muted);font-size:.88rem;margin-bottom:1.5rem;">
            {{ $dosen->prodi->nama_prodi ?? $dosen->prodi->nama ?? 'Dosen' }}
        </p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
            <div style="background:var(--light-green);border-radius:12px;padding:.85rem;">
                <div style="font-size:1.5rem;font-weight:700;color:var(--dark-green);">
                    {{ $dosen->mahasiswaPembimbing1->count() }}
                </div>
                <div style="font-size:.75rem;color:var(--text-muted);">Pembimbing 1</div>
            </div>
            <div style="background:#ebf5fb;border-radius:12px;padding:.85rem;">
                <div style="font-size:1.5rem;font-weight:700;color:#3498db;">
                    {{ $dosen->mahasiswaPembimbing2->count() }}
                </div>
                <div style="font-size:.75rem;color:var(--text-muted);">Pembimbing 2</div>
            </div>
        </div>

        <form action="{{ route('admin.dosen.destroy', $dosen->id) }}" method="POST"
            onsubmit="return confirm('Hapus dosen {{ addslashes($dosen->nama) }}? Akun login juga akan terhapus.')">
            @csrf @method('DELETE')
            <button type="submit" style="width:100%;padding:.7rem;background:#fdedec;color:#e74c3c;border:none;border-radius:10px;font-weight:500;cursor:pointer;font-family:'Poppins',sans-serif;">
                <i class="fas fa-trash"></i> Hapus Dosen
            </button>
        </form>
    </div>

    {{-- Detail Info --}}
    <div style="display:flex;flex-direction:column;gap:1.5rem;">

        {{-- Data Pribadi --}}
        <div class="table-card">
            <h6 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.25rem;">
                <i class="fas fa-id-card"></i> Data Pribadi
            </h6>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                @foreach([
                    ['Nama Lengkap', $dosen->nama],
                    ['NUPTK', $dosen->nuptk ?? '-'],
                    ['Program Studi', $dosen->prodi->nama_prodi ?? $dosen->prodi->nama ?? '-'],
                    ['Email', $dosen->user->email ?? '-'],
                    ['Login Username', $dosen->user->nim_nuptk ?? '-'],
                    ['Terdaftar', \Carbon\Carbon::parse($dosen->created_at)->format('d M Y')],
                ] as [$label, $val])
                <div>
                    <div style="font-size:.78rem;color:var(--text-muted);margin-bottom:.2rem;">{{ $label }}</div>
                    <div style="font-weight:500;font-size:.9rem;">{{ $val }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Mahasiswa Bimbingan 1 --}}
        @if($dosen->mahasiswaPembimbing1->count() > 0)
        <div class="table-card">
            <h6 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.25rem;">
                <i class="fas fa-user-graduate"></i> Mahasiswa Pembimbing 1
                <span style="background:var(--light-green);color:var(--dark-green);padding:.2rem .6rem;border-radius:20px;font-size:.75rem;margin-left:.5rem;">
                    {{ $dosen->mahasiswaPembimbing1->count() }}
                </span>
            </h6>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead><tr><th>Nama</th><th>NIM</th><th>Prodi</th></tr></thead>
                    <tbody>
                        @foreach($dosen->mahasiswaPembimbing1 as $m)
                        <tr>
                            <td><strong>{{ $m->nama }}</strong></td>
                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->prodi->nama_prodi ?? $m->prodi->nama ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Mahasiswa Bimbingan 2 --}}
        @if($dosen->mahasiswaPembimbing2->count() > 0)
        <div class="table-card">
            <h6 style="font-weight:600;color:#3498db;border-bottom:2px solid #ebf5fb;padding-bottom:.75rem;margin-bottom:1.25rem;">
                <i class="fas fa-user-graduate"></i> Mahasiswa Pembimbing 2
                <span style="background:#ebf5fb;color:#3498db;padding:.2rem .6rem;border-radius:20px;font-size:.75rem;margin-left:.5rem;">
                    {{ $dosen->mahasiswaPembimbing2->count() }}
                </span>
            </h6>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead><tr><th>Nama</th><th>NIM</th><th>Prodi</th></tr></thead>
                    <tbody>
                        @foreach($dosen->mahasiswaPembimbing2 as $m)
                        <tr>
                            <td><strong>{{ $m->nama }}</strong></td>
                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->prodi->nama_prodi ?? $m->prodi->nama ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($dosen->mahasiswaPembimbing1->count() == 0 && $dosen->mahasiswaPembimbing2->count() == 0)
        <div class="table-card" style="text-align:center;padding:2rem;">
            <i class="fas fa-user-graduate" style="font-size:2.5rem;color:#dee2e6;margin-bottom:.75rem;display:block;"></i>
            <p style="color:var(--text-muted);">Belum ada mahasiswa bimbingan</p>
        </div>
        @endif

    </div>
</div>

@endsection