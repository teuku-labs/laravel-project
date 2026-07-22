@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <h2 style="font-weight:700;">SK Pembimbing</h2>
    <p style="color:var(--text-muted);font-size:.9rem;">Daftar pengajuan SK Pembimbing mahasiswa</p>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="table-card">
    <div class="table-header">
        <div class="table-title"><i class="fas fa-file-signature"></i> Daftar Pengajuan SK Pembimbing</div>
    </div>
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>NIM</th>
                    <th>Pembimbing 1</th>
                    <th>Pembimbing 2</th>
                    <th>No. SK</th>
                    <th>Diajukan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuanSks as $i => $p)
                <tr>
                    <td>{{ $pengajuanSks->firstItem() + $i }}</td>
                    <td><strong>{{ $p->mahasiswa->nama ?? '-' }}</strong></td>
                    <td>{{ $p->mahasiswa->nim ?? '-' }}</td>
                    <td>{{ $p->pembimbing1->nama ?? '-' }}</td>
                    <td>{{ $p->pembimbing2->nama ?? '-' }}</td>
                    <td>{{ $p->nomor_sk ?? '-' }}</td>
                    <td style="font-size:.82rem;color:var(--text-muted);">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>
                    <td>
                        @if($p->kaprodi_rejected)
                            <span class="status-badge status-rejected"><i class="fas fa-times"></i> Ditolak Kaprodi</span>
                        @elseif($p->kaprodi_approved)
                            <span class="status-badge status-approved"><i class="fas fa-check-double"></i> Disetujui Kaprodi</span>
                        @elseif($p->admin_verified)
                            <span class="status-badge status-editing"><i class="fas fa-paper-plane"></i> Menunggu Kaprodi</span>
                        @else
                            <span class="status-badge status-pending"><i class="fas fa-clock"></i> Menunggu Verifikasi</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.sk-pembimbing.show', $p->id) }}" class="action-btn view"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.sk-pembimbing.edit', $p->id) }}" class="action-btn edit"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted"><i class="fas fa-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1rem;">{{ $pengajuanSks->links() }}</div>
</div>
@endsection