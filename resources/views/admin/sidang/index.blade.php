@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <h2 style="font-weight:700;">Pengajuan Sidang</h2>
    <p style="color:var(--text-muted);font-size:.9rem;">Daftar semua pengajuan sidang skripsi mahasiswa</p>
</div>

<div class="stats-grid" style="margin-bottom:2rem;">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-gavel"></i></div>
        <div class="stat-content"><div class="label">Total Pengajuan</div><div class="value">{{ $totalSidang }}</div></div>
    </div>
    <div class="stat-card warning">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-content"><div class="label">Belum Diverifikasi</div><div class="value">{{ $belumVerifikasi }}</div></div>
    </div>
    <div class="stat-card info">
        <div class="stat-icon"><i class="fas fa-check-double"></i></div>
        <div class="stat-content"><div class="label">Disetujui Kaprodi</div><div class="value">{{ $disetujuiKaprodi }}</div></div>
    </div>
</div>

<div class="table-card">
    <div class="table-header">
        <div class="table-title"><i class="fas fa-clipboard-list"></i> Daftar Pengajuan Sidang</div>
    </div>
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>NIM</th>
                    <th>Judul Skripsi</th>
                    <th>Pembimbing</th>
                    <th>Tanggal Sidang</th>
                    <th>Berkas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sidangs as $i => $s)
                <tr>
                    <td>{{ $sidangs->firstItem() + $i }}</td>
                    <td><strong>{{ $s->mahasiswa->nama ?? '-' }}</strong></td>
                    <td>{{ $s->mahasiswa->nim ?? '-' }}</td>
                    <td>{{ Str::limit($s->judul_skripsi ?? '-', 35) }}</td>
                    <td>{{ $s->pembimbing->nama ?? '-' }}</td>
                    <td style="font-size:.82rem;color:var(--text-muted);">
                        {{ $s->tanggal_sidang ? \Carbon\Carbon::parse($s->tanggal_sidang)->format('d M Y') : 'Belum dijadwal' }}
                    </td>
                    <td style="white-space:nowrap;">
                        @if($s->file_draft)
                            <a href="{{ asset('storage/'.$s->file_draft) }}" target="_blank" class="action-btn view" title="Draft Skripsi"><i class="fas fa-file-pdf"></i></a>
                        @endif
                        @if($s->bukti_transfer)
                            <a href="{{ asset('storage/'.$s->bukti_transfer) }}" target="_blank" class="action-btn view" title="Bukti Transfer"><i class="fas fa-image"></i></a>
                        @endif
                        @if(!$s->file_draft && !$s->bukti_transfer)-@endif
                    </td>
                    <td>
                        @if($s->kaprodi_approved)
                            <span class="status-badge status-approved"><i class="fas fa-check-double"></i> Disetujui Kaprodi</span>
                        @elseif($s->admin_verified)
                            <span class="status-badge status-editing"><i class="fas fa-paper-plane"></i> Menunggu Kaprodi</span>
                        @else
                            <span class="status-badge status-pending"><i class="fas fa-clock"></i> Menunggu Verifikasi Admin</span>
                        @endif
                    </td>
                    <td><a href="{{ route('admin.sidang.show', $s->id) }}" class="action-btn view" title="Detail / Verifikasi"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted"><i class="fas fa-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1rem;">{{ $sidangs->links() }}</div>
</div>
@endsection