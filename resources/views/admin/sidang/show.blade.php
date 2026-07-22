@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <a href="{{ route('admin.sidang.index') }}" style="color:var(--primary-green);text-decoration:none;font-size:.9rem;"><i class="fas fa-arrow-left"></i> Kembali</a>
    <h2 style="font-weight:700;margin-top:.5rem;">Detail Pengajuan Sidang Skripsi</h2>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    <div class="table-card">
        <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.25rem;"><i class="fas fa-user-graduate"></i> Data Mahasiswa</h5>
        @foreach([['Nama',$sidang->mahasiswa->nama ?? '-'],['NIM',$sidang->mahasiswa->nim ?? '-'],['Angkatan',$sidang->mahasiswa->angkatan ?? '-'],['Program Studi',$sidang->mahasiswa->prodi->nama ?? '-'],['Pembimbing',$sidang->pembimbing->nama ?? '-']] as [$label,$val])
        <div style="display:flex;padding:.7rem 0;border-bottom:1px solid #eee;gap:.75rem;">
            <span style="font-size:.82rem;color:var(--text-muted);min-width:140px;">{{ $label }}</span>
            <span style="font-weight:500;font-size:.88rem;">{{ $val }}</span>
        </div>
        @endforeach

        <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin:1.5rem 0 1.25rem;"><i class="fas fa-folder-open"></i> Berkas</h5>
        <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
            @if($sidang->file_draft)
                <a href="{{ asset('storage/'.$sidang->file_draft) }}" target="_blank" style="text-decoration:none;color:var(--primary-green);font-size:.85rem;"><i class="fas fa-file-pdf"></i> Draft Skripsi</a>
            @endif
            @if($sidang->file_bebas_pustaka)
                <a href="{{ asset('storage/'.$sidang->file_bebas_pustaka) }}" target="_blank" style="text-decoration:none;color:var(--primary-green);font-size:.85rem;"><i class="fas fa-file-alt"></i> Bebas Pustaka</a>
            @endif
            @if($sidang->bukti_transfer)
                <a href="{{ asset('storage/'.$sidang->bukti_transfer) }}" target="_blank" style="text-decoration:none;color:var(--primary-green);font-size:.85rem;"><i class="fas fa-image"></i> Bukti Transfer</a>
            @endif
            @if(!$sidang->file_draft && !$sidang->file_bebas_pustaka && !$sidang->bukti_transfer)
                <span style="color:var(--text-muted);font-size:.85rem;">Tidak ada berkas.</span>
            @endif
        </div>
    </div>

    <div class="table-card">
        <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.25rem;"><i class="fas fa-gavel"></i> Status Pengajuan</h5>
        <div style="display:flex;flex-direction:column;gap:.85rem;">
            <div><span style="font-size:.78rem;color:var(--text-muted);">Judul Skripsi</span><p style="font-weight:500;margin:0;">{{ $sidang->judul_skripsi ?? '-' }}</p></div>
            <div><span style="font-size:.78rem;color:var(--text-muted);">Tanggal Diajukan</span><p style="font-weight:500;margin:0;">{{ \Carbon\Carbon::parse($sidang->created_at)->format('d M Y') }}</p></div>
            <div>
                <span style="font-size:.78rem;color:var(--text-muted);">Status</span>
                <p style="margin:.25rem 0 0;">
                    @if($sidang->kaprodi_rejected)
                        <span class="status-badge status-rejected"><i class="fas fa-times"></i> Ditolak Kaprodi</span>
                    @elseif($sidang->kaprodi_approved)
                        <span class="status-badge status-approved"><i class="fas fa-check-double"></i> Disetujui Kaprodi</span>
                    @elseif($sidang->admin_verified)
                        <span class="status-badge status-editing"><i class="fas fa-paper-plane"></i> Menunggu Kaprodi</span>
                    @else
                        <span class="status-badge status-pending"><i class="fas fa-clock"></i> Menunggu Verifikasi Admin</span>
                    @endif
                </p>
            </div>
            @if($sidang->catatan_kaprodi)
            <div><span style="font-size:.78rem;color:var(--text-muted);">Catatan Kaprodi</span><p style="font-weight:500;margin:0;">{{ $sidang->catatan_kaprodi }}</p></div>
            @endif
        </div>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;flex-wrap:wrap;">
            @if(!$sidang->admin_verified)
            <form action="{{ route('admin.sidang.verify', $sidang->id) }}" method="POST" onsubmit="return confirm('Verifikasi kelengkapan berkas dan kirim ke Kaprodi?');">
                @csrf
                <button type="submit" style="background:#3498db;color:white;border:none;padding:.7rem 1.25rem;border-radius:10px;font-weight:600;font-size:.88rem;cursor:pointer;"><i class="fas fa-paper-plane"></i> Verifikasi &amp; Kirim ke Kaprodi</button>
            </form>
            @else
            <p style="color:var(--text-muted);font-size:.85rem;">Sudah diverifikasi. Keputusan setuju/tolak selanjutnya ada di tangan Kaprodi.</p>
            @endif
        </div>
    </div>
</div>
@endsection