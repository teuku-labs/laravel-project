@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <a href="{{ route('admin.proposal.index') }}" style="color:var(--primary-green);text-decoration:none;font-size:.9rem;"><i class="fas fa-arrow-left"></i> Kembali</a>
    <h2 style="font-weight:700;margin-top:.5rem;">Detail Pendaftaran Seminar Proposal</h2>
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
        @foreach([['Nama',$proposal->mahasiswa->nama ?? '-'],['NIM',$proposal->mahasiswa->nim ?? '-'],['Angkatan',$proposal->mahasiswa->angkatan ?? '-'],['Program Studi',$proposal->mahasiswa->prodi->nama_prodi ?? '-'],['Pembimbing 1',$proposal->pembimbing1->nama ?? '-']] as [$label,$val])
        <div style="display:flex;padding:.7rem 0;border-bottom:1px solid #eee;gap:.75rem;">
            <span style="font-size:.82rem;color:var(--text-muted);min-width:140px;">{{ $label }}</span>
            <span style="font-weight:500;font-size:.88rem;">{{ $val }}</span>
        </div>
        @endforeach

        <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin:1.5rem 0 1.25rem;"><i class="fas fa-folder-open"></i> Berkas</h5>
        <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
            @if($proposal->file_proposal)
                <a href="{{ asset('storage/'.$proposal->file_proposal) }}" target="_blank" style="text-decoration:none;color:var(--primary-green);font-size:.85rem;"><i class="fas fa-file-pdf"></i> File Proposal</a>
            @else
                <span style="color:var(--text-muted);font-size:.85rem;">Tidak ada berkas.</span>
            @endif
        </div>
    </div>

    <div class="table-card">
        <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.25rem;"><i class="fas fa-file-alt"></i> Status Pendaftaran</h5>
        <div style="display:flex;flex-direction:column;gap:.85rem;">
            <div><span style="font-size:.78rem;color:var(--text-muted);">Judul Skripsi</span><p style="font-weight:500;margin:0;">{{ $proposal->judul ?? '-' }}</p></div>
            <div><span style="font-size:.78rem;color:var(--text-muted);">Tanggal Mendaftar</span><p style="font-weight:500;margin:0;">{{ \Carbon\Carbon::parse($proposal->created_at)->format('d M Y') }}</p></div>
            <div>
                <span style="font-size:.78rem;color:var(--text-muted);">Status</span>
                <p style="margin:.25rem 0 0;">
                    @if($proposal->tanggal_seminar)
                        <span class="status-badge status-approved"><i class="fas fa-calendar-check"></i> Terjadwal {{ \Carbon\Carbon::parse($proposal->tanggal_seminar)->format('d M Y') }}</span>
                    @else
                        <span class="status-badge status-editing"><i class="fas fa-paper-plane"></i> Menunggu Jadwal Kaprodi</span>
                    @endif
                </p>
            </div>
        </div>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;flex-wrap:wrap;">
            <p style="color:var(--text-muted);font-size:.85rem;">Pendaftaran langsung diteruskan ke Kaprodi untuk penentuan jadwal dan dosen pembahas/penguji. Tidak ada verifikasi admin.</p>
        </div>
    </div>
</div>
@endsection