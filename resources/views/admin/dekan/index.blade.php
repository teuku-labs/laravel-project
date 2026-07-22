@extends('layouts.admin')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
    <div><h2 style="font-weight:700;">Kelola Dekan</h2><p style="color:var(--text-muted);font-size:.9rem;">Manajemen data Dekan Fakultas</p></div>
    <a href="{{ route('admin.dekan.create') }}" style="background:linear-gradient(135deg,var(--primary-green),var(--dark-green));color:white;padding:.75rem 1.5rem;border-radius:12px;text-decoration:none;font-weight:500;display:inline-flex;align-items:center;gap:.5rem;"><i class="fas fa-plus"></i> Tambah Dekan</a>
</div>
@if(session('success'))<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="table-card">
    <table class="custom-table">
        <thead><tr><th>No</th><th>Nama</th><th>NUPTK</th><th>Program Studi</th><th>Email</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse($dekans as $i => $d)
            <tr>
                <td>{{ $dekans->firstItem() + $i }}</td>
                <td><strong>{{ $d->nama }}</strong></td>
                <td>{{ $d->nuptk }}</td>
                <td>{{ $d->prodi->nama ?? '-' }}</td>
                <td>{{ $d->user->email ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.dekan.edit', $d->id) }}" class="action-btn edit"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.dekan.destroy', $d->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus Dekan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-btn delete"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-4 text-muted"><i class="fas fa-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Belum ada data Dekan</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $dekans->links() }}</div>
</div>
@endsection