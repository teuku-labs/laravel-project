@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <h2 style="font-weight:700;">Pengajuan Seminar Proposal</h2>
    <p style="color:var(--text-muted);font-size:.9rem;">Verifikasi kelengkapan berkas pendaftaran seminar proposal mahasiswa</p>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="stats-grid" style="margin-bottom:2rem;">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
        <div class="stat-content"><div class="label">Total Pendaftar</div><div class="value">{{ $totalProposal }}</div></div>
    </div>
    <div class="stat-card warning">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-content"><div class="label">Menunggu Jadwal Kaprodi</div><div class="value">{{ $menungguJadwal }}</div></div>
    </div>
    <div class="stat-card info">
        <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
        <div class="stat-content"><div class="label">Sudah Terjadwal</div><div class="value">{{ $terjadwal }}</div></div>
    </div>
</div>

<div class="table-card">
    <div class="table-header">
        <div class="table-title"><i class="fas fa-clipboard-list"></i> Daftar Pendaftaran Proposal</div>
        <form method="GET" style="display:flex;gap:.5rem;flex-wrap:wrap;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIM..." style="padding:.5rem .9rem;border:2px solid #eee;border-radius:10px;font-size:.85rem;">
            <select name="status" onchange="this.form.submit()" style="padding:.5rem .9rem;border:2px solid #eee;border-radius:10px;font-size:.85rem;">
                <option value="">Semua Status</option>
                <option value="menunggu_jadwal" {{ request('status') === 'menunggu_jadwal' ? 'selected' : '' }}>Menunggu Jadwal</option>
                <option value="terjadwal" {{ request('status') === 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
            </select>
        </form>
    </div>
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>NIM</th>
                    <th>Judul Skripsi</th>
                    <th>Pembimbing 1</th>
                    <th>Tgl Daftar</th>
                    <th>Berkas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proposals as $i => $p)
                <tr>
                    <td>{{ $proposals->firstItem() + $i }}</td>
                    <td><strong>{{ $p->mahasiswa->nama ?? '-' }}</strong></td>
                    <td>{{ $p->mahasiswa->nim ?? '-' }}</td>
                    <td>{{ Str::limit($p->judul ?? '-', 35) }}</td>
                    <td>{{ $p->pembimbing1->nama ?? '-' }}</td>
                    <td style="font-size:.82rem;color:var(--text-muted);">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>
                    <td>
                        @if($p->file_proposal)
                            <a href="{{ asset('storage/'.$p->file_proposal) }}" target="_blank" class="action-btn view" title="File Proposal"><i class="fas fa-file-pdf"></i></a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($p->tanggal_seminar)
                            <span class="status-badge status-approved"><i class="fas fa-calendar-check"></i> Terjadwal {{ \Carbon\Carbon::parse($p->tanggal_seminar)->format('d M Y') }}</span>
                        @else
                            <span class="status-badge status-editing"><i class="fas fa-paper-plane"></i> Menunggu Jadwal Kaprodi</span>
                        @endif
                    </td>
                    <td><a href="{{ route('admin.proposal.show', $p->id) }}" class="action-btn view" title="Detail"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted"><i class="fas fa-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1rem;">{{ $proposals->links() }}</div>
</div>
@endsection