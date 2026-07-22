@extends('layouts.admin')

@section('content')

{{-- Alert --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Page Header --}}
<div style="margin-bottom:2rem;">
    <h2 style="font-weight:700;color:var(--text-dark);">Dashboard Admin</h2>
    <p style="color:var(--text-muted);font-size:.9rem;">Selamat datang, {{ Auth::user()->username }}. Berikut ringkasan sistem hari ini.</p>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div class="stat-content">
            <div class="label">Total Dosen</div>
            <div class="value">{{ $totalDosen }}</div>
            <div class="change positive"><i class="fas fa-plus"></i> {{ $newDosen }} bulan ini</div>
        </div>
    </div>
    <div class="stat-card info">
        <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-content">
            <div class="label">Total Mahasiswa</div>
            <div class="value">{{ $totalMahasiswa }}</div>
            <div class="change positive"><i class="fas fa-plus"></i> {{ $newMahasiswa }} bulan ini</div>
        </div>
    </div>
    <div class="stat-card warning">
        <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
        <div class="stat-content">
            <div class="label">Kaprodi</div>
            <div class="value">{{ $totalKaprodi }}</div>
            <div class="change positive"><i class="fas fa-check"></i> Terdaftar</div>
        </div>
    </div>
    <div class="stat-card danger">
        <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
        <div class="stat-content">
            <div class="label">Seminar LKP Pending</div>
            <div class="value">{{ $pendingSeminar }}</div>
            <div class="change negative"><i class="fas fa-clock"></i> Belum dijadwal</div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<h5 style="font-weight:600;margin-bottom:1rem;">⚡ Aksi Cepat</h5>
<div class="quick-actions" style="margin-bottom:2rem;">
    <a href="{{ route('admin.dosen.create') }}" class="quick-action-btn">
        <i class="fas fa-user-plus"></i><span>Tambah Dosen</span>
    </a>
    <a href="{{ route('admin.kaprodi.create') }}" class="quick-action-btn">
        <i class="fas fa-user-tie"></i><span>Tambah Kaprodi</span>
    </a>
    <a href="{{ route('admin.dekan.create') }}" class="quick-action-btn">
        <i class="fas fa-user-shield"></i><span>Tambah Dekan</span>
    </a>
    <a href="{{ route('admin.seminar.index') }}" class="quick-action-btn">
        <i class="fas fa-clipboard-list"></i><span>Lihat Seminar LKP</span>
    </a>
    <a href="{{ route('admin.mahasiswa.index') }}" class="quick-action-btn">
        <i class="fas fa-user-graduate"></i><span>Data Mahasiswa</span>
    </a>
</div>

{{-- Tabel Seminar LKP Terbaru --}}
<div class="table-card">
    <div class="table-header">
        <div class="table-title"><i class="fas fa-file-alt"></i> Pendaftaran Seminar LKP Terbaru</div>
        <a href="{{ route('admin.seminar.index') }}" class="btn-view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>
    <table class="custom-table">
        <thead>
            <tr><th>Mahasiswa</th><th>NIM</th><th>Judul LKP</th><th>Pembimbing</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($seminarTerbaru as $s)
            <tr>
                <td><strong>{{ $s->mahasiswa->nama ?? '-' }}</strong></td>
                <td>{{ $s->mahasiswa->nim ?? '-' }}</td>
                <td>{{ Str::limit($s->judul_lkp, 40) }}</td>
                <td>{{ $s->dosen->nama ?? '-' }}</td>
                <td>
                    @if($s->tanggal_seminar)
                        <span class="status-badge status-approved"><i class="fas fa-check"></i> Terjadwal</span>
                    @else
                        <span class="status-badge status-pending"><i class="fas fa-clock"></i> Pending</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.seminar.show', $s->id) }}" class="action-btn view"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-4 text-muted"><i class="fas fa-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Belum ada pendaftaran</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Tabel Mahasiswa Terbaru --}}
<div class="table-card">
    <div class="table-header">
        <div class="table-title"><i class="fas fa-user-graduate"></i> Mahasiswa Terdaftar Terbaru</div>
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn-view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>
    <table class="custom-table">
        <thead>
            <tr><th>Nama</th><th>NIM</th><th>Prodi</th><th>Pembimbing 1</th><th>Terdaftar</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($mahasiswaTerbaru as $m)
            <tr>
                <td><strong>{{ $m->nama }}</strong></td>
                <td>{{ $m->nim }}</td>
                <td>{{ $m->prodi->nama ?? '-' }}</td>
                <td>{{ $m->pembimbing1->nama ?? '<span style="color:#aaa">Belum dipilih</span>' }}</td>
                <td>{{ \Carbon\Carbon::parse($m->created_at)->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.mahasiswa.show', $m->id) }}" class="action-btn view"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-4 text-muted"><i class="fas fa-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Belum ada mahasiswa</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection