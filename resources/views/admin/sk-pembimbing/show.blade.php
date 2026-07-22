@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <a href="{{ route('admin.sk-pembimbing.index') }}" style="color:var(--primary-green);text-decoration:none;font-size:.9rem;"><i class="fas fa-arrow-left"></i> Kembali</a>
    <h2 style="font-weight:700;margin-top:.5rem;">Detail Pengajuan SK Pembimbing</h2>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    <div class="table-card">
        <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.25rem;"><i class="fas fa-user-graduate"></i> Data Mahasiswa</h5>
        @foreach([['Nama',$pengajuan->mahasiswa->nama ?? '-'],['NIM',$pengajuan->mahasiswa->nim ?? '-'],['Angkatan',$pengajuan->mahasiswa->angkatan ?? '-'],['Program Studi',$pengajuan->mahasiswa->prodi->nama ?? '-']] as [$label,$val])
        <div style="display:flex;padding:.7rem 0;border-bottom:1px solid #eee;gap:.75rem;">
            <span style="font-size:.82rem;color:var(--text-muted);min-width:140px;">{{ $label }}</span>
            <span style="font-weight:500;font-size:.88rem;">{{ $val }}</span>
        </div>
        @endforeach
    </div>

    <div class="table-card">
        <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.25rem;"><i class="fas fa-file-signature"></i> Data Pengajuan SK</h5>
        <div style="display:flex;flex-direction:column;gap:.85rem;">
            <div><span style="font-size:.78rem;color:var(--text-muted);">Pembimbing 1</span><p style="font-weight:500;margin:0;">{{ $pengajuan->pembimbing1->nama ?? '-' }}</p></div>
            <div><span style="font-size:.78rem;color:var(--text-muted);">Pembimbing 2</span><p style="font-weight:500;margin:0;">{{ $pengajuan->pembimbing2->nama ?? '-' }}</p></div>
            <div><span style="font-size:.78rem;color:var(--text-muted);">Nomor SK</span><p style="font-weight:500;margin:0;">{{ $pengajuan->nomor_sk ?? 'Belum diisi' }}</p></div>
            <div><span style="font-size:.78rem;color:var(--text-muted);">Tanggal Diajukan</span><p style="font-weight:500;margin:0;">{{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d M Y') }}</p></div>
            <div>
                <span style="font-size:.78rem;color:var(--text-muted);">Status</span>
                <p style="margin:.25rem 0 0;">
                    @if($pengajuan->kaprodi_rejected)
                        <span class="status-badge status-rejected"><i class="fas fa-times"></i> Ditolak Kaprodi</span>
                    @elseif($pengajuan->kaprodi_approved)
                        <span class="status-badge status-approved"><i class="fas fa-check-double"></i> Disetujui Kaprodi</span>
                    @elseif($pengajuan->admin_verified)
                        <span class="status-badge status-editing"><i class="fas fa-paper-plane"></i> Menunggu Kaprodi</span>
                    @else
                        <span class="status-badge status-pending"><i class="fas fa-clock"></i> Menunggu Verifikasi Admin</span>
                    @endif
                </p>
            </div>
            @if($pengajuan->catatan_kaprodi)
            <div><span style="font-size:.78rem;color:var(--text-muted);">Catatan Kaprodi</span><p style="font-weight:500;margin:0;">{{ $pengajuan->catatan_kaprodi }}</p></div>
            @endif
        </div>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;flex-wrap:wrap;">
            <a href="{{ route('admin.sk-pembimbing.edit', $pengajuan->id) }}" style="background:linear-gradient(135deg,var(--primary-green),var(--dark-green));color:white;text-decoration:none;padding:.7rem 1.25rem;border-radius:10px;font-weight:600;font-size:.88rem;"><i class="fas fa-edit"></i> Isi / Edit Nomor SK</a>
            @if(!$pengajuan->admin_verified)
            <form action="{{ route('admin.sk-pembimbing.submit-approval', $pengajuan->id) }}" method="POST" onsubmit="return confirm('Verifikasi pengajuan ini dan kirim ke Kaprodi?');">
                @csrf
                <button type="submit" style="background:#3498db;color:white;border:none;padding:.7rem 1.25rem;border-radius:10px;font-weight:600;font-size:.88rem;cursor:pointer;"><i class="fas fa-paper-plane"></i> Verifikasi &amp; Kirim ke Kaprodi</button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
