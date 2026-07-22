@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <h2 style="font-weight:700;">Data Mahasiswa</h2>
    <p style="color:var(--text-muted);font-size:.9rem;">Daftar semua mahasiswa yang terdaftar (view only)</p>
</div>

<div class="table-card">
    <div class="table-header" style="flex-wrap:wrap;gap:1rem;">
        <div class="table-title"><i class="fas fa-user-graduate"></i> Semua Mahasiswa ({{ $mahasiswas->total() }})</div>
        <form method="GET" action="{{ route('admin.mahasiswa.index') }}" style="display:flex;gap:.75rem;flex-wrap:wrap;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIM..." class="form-control" style="width:220px;">
            <select name="prodi_id" class="form-select" style="width:180px;">
                <option value="">Semua Prodi</option>
                @foreach($prodis as $p)
                <option value="{{ $p->id }}" {{ request('prodi_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                @endforeach
            </select>
            <button type="submit" style="background:var(--primary-green);color:white;border:none;padding:.5rem 1rem;border-radius:8px;cursor:pointer;"><i class="fas fa-search"></i></button>
            @if(request('search') || request('prodi_id'))
            <a href="{{ route('admin.mahasiswa.index') }}" style="background:#eee;color:#333;padding:.5rem 1rem;border-radius:8px;text-decoration:none;">Reset</a>
            @endif
        </form>
    </div>
    <div class="table-responsive">
        <table class="custom-table">
            <thead><tr><th>No</th><th>Nama</th><th>NIM</th><th>Prodi</th><th>Pembimbing 1</th><th>Seminar LKP</th><th>Terdaftar</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($mahasiswas as $i => $m)
                <tr>
                    <td>{{ $mahasiswas->firstItem() + $i }}</td>
                    <td><strong>{{ $m->nama }}</strong></td>
                    <td>{{ $m->nim }}</td>
                    <td>{{ $m->prodi->nama ?? '-' }}</td>
                    <td>{{ $m->pembimbing1->nama ?? '<span style="color:#aaa;font-size:.8rem;">Belum dipilih</span>' }}</td>
                    <td>
                        @if($m->seminarLkp)
                            <span class="status-badge status-approved"><i class="fas fa-check"></i> Sudah Daftar</span>
                        @else
                            <span class="status-badge status-pending"><i class="fas fa-clock"></i> Belum</span>
                        @endif
                    </td>
                    <td style="font-size:.82rem;color:var(--text-muted);">{{ \Carbon\Carbon::parse($m->created_at)->format('d M Y') }}</td>
                    <td><a href="{{ route('admin.mahasiswa.show', $m->id) }}" class="action-btn view"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted"><i class="fas fa-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Tidak ada data mahasiswa</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1rem;">{{ $mahasiswas->links() }}</div>
</div>
@endsection