@extends('layouts.admin')

@section('content')

{{-- Alerts --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-3">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-3">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Page Header --}}
<div class="page-header">
    <div class="page-title">
        <i class="fas fa-chalkboard-teacher"></i>
        <span>Kelola Dosen</span>
    </div>
    <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary-custom">
        <i class="fas fa-plus"></i> Tambah Dosen Baru
    </a>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-content">
            <div class="label">Total Dosen</div>
            <div class="value">{{ $totalDosen }}</div>
            <div class="change positive"><i class="fas fa-user-check"></i> Terdaftar di sistem</div>
        </div>
    </div>
    <div class="stat-card info">
        <div class="stat-icon"><i class="fas fa-book"></i></div>
        <div class="stat-content">
            <div class="label">Program Studi</div>
            <div class="value">{{ $prodis->count() }}</div>
            <div class="change positive"><i class="fas fa-graduation-cap"></i> Prodi aktif</div>
        </div>
    </div>
    <div class="stat-card warning">
        <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-content">
            <div class="label">Total Bimbingan</div>
            <div class="value">{{ $dosens->sum('mahasiswa_count') }}</div>
            <div class="change positive"><i class="fas fa-users"></i> Mahasiswa aktif</div>
        </div>
    </div>
</div>

{{-- Tabel --}}
<div class="table-card">

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('admin.dosen.index') }}">
        <div class="table-filters">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau NUPTK...">
            </div>
            <select class="filter-select" name="prodi_id" onchange="this.form.submit()">
                <option value="">Semua Prodi</option>
                @foreach($prodis as $prodi)
                    <option value="{{ $prodi->id }}" {{ request('prodi_id') == $prodi->id ? 'selected' : '' }}>
                        {{ $prodi->nama_prodi ?? $prodi->nama }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary-custom" style="padding:.65rem 1.25rem;">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request()->anyFilled(['search','prodi_id']))
                <a href="{{ route('admin.dosen.index') }}" class="btn" style="padding:.65rem 1.25rem;background:#eee;color:#333;border-radius:10px;">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="custom-table" id="dosenTable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Dosen</th>
                    <th width="15%">NUPTK</th>
                    <th width="20%">Program Studi</th>
                    <th width="10%">Email</th>
                    <th width="10%">Mahasiswa</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dosens as $index => $dosen)
                <tr>
                    <td>{{ $dosens->firstItem() + $index }}</td>
                    <td>
                        <div class="dosen-info">
                            <div class="dosen-avatar">{{ substr($dosen->nama, 0, 1) }}</div>
                            <div>
                                <div class="name">{{ $dosen->nama }}</div>
                                <div class="nip" style="font-size:.78rem;color:var(--text-muted);">
                                    {{ $dosen->user->email ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><code>{{ $dosen->nuptk ?? '-' }}</code></td>
                    <td>{{ $dosen->prodi->nama_prodi ?? $dosen->prodi->nama ?? '-' }}</td>
                    <td style="font-size:.82rem;">{{ $dosen->user->email ?? '-' }}</td>
                    <td>
                        <span style="background:var(--light-green);color:var(--dark-green);padding:.3rem .75rem;border-radius:20px;font-size:.78rem;font-weight:500;">
                            {{ $dosen->mahasiswa_count ?? 0 }} Mhs
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.dosen.show', $dosen->id) }}" class="action-btn view" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.dosen.edit', $dosen->id) }}" class="action-btn edit" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="action-btn delete" onclick="confirmDelete({{ $dosen->id }}, '{{ addslashes($dosen->nama) }}')" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-inbox" style="font-size:3rem;color:#dee2e6;display:block;margin-bottom:1rem;"></i>
                        <p class="text-muted">Belum ada data dosen</p>
                        <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary-custom btn-sm">
                            <i class="fas fa-plus"></i> Tambah Dosen Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:1.5rem;flex-wrap:wrap;gap:1rem;">
        <div style="color:var(--text-muted);font-size:.88rem;">
            Menampilkan {{ $dosens->firstItem() ?? 0 }}–{{ $dosens->lastItem() ?? 0 }}
            dari {{ $dosens->total() }} data
        </div>
        {{ $dosens->withQueryString()->links() }}
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,var(--dark-green),var(--primary-green));color:white;">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus dosen <strong id="deleteName"></strong>?</p>
                <div class="alert alert-warning mb-0">
                    <i class="fas fa-info-circle"></i> Data yang dihapus tidak dapat dikembalikan.
                    Akun login dosen ini juga akan ikut terhapus.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteForm').action = '/admin/dosen/' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

@endsection