@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <a href="{{ route('admin.seminar.index') }}" style="color:var(--primary-green);text-decoration:none;font-size:.9rem;"><i class="fas fa-arrow-left"></i> Kembali</a>
    <h2 style="font-weight:700;margin-top:.5rem;">Detail Seminar LKP</h2>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    <div class="table-card">
        <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.25rem;"><i class="fas fa-user-graduate"></i> Data Mahasiswa</h5>
        @foreach([['Nama',$seminar->mahasiswa->nama ?? '-'],['NIM',$seminar->mahasiswa->nim ?? '-'],['Email',$seminar->email],['No HP',$seminar->no_hp],['NIK KTP',$seminar->nik_ktp],['Tempat Lahir',$seminar->tempat_lahir]] as [$label,$val])
        <div style="display:flex;padding:.7rem 0;border-bottom:1px solid #eee;gap:.75rem;">
            <span style="font-size:.82rem;color:var(--text-muted);min-width:130px;">{{ $label }}</span>
            <span style="font-weight:500;font-size:.88rem;">{{ $val }}</span>
        </div>
        @endforeach
        <div style="display:flex;padding:.7rem 0;gap:.75rem;">
            <span style="font-size:.82rem;color:var(--text-muted);min-width:130px;">Tanggal Lahir</span>
            <span style="font-weight:500;font-size:.88rem;">{{ \Carbon\Carbon::parse($seminar->tanggal_lahir)->format('d M Y') }}</span>
        </div>
    </div>

    <div class="table-card">
        <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.25rem;"><i class="fas fa-file-alt"></i> Data Seminar</h5>
        <div style="display:flex;flex-direction:column;gap:.85rem;">
            <div><span style="font-size:.78rem;color:var(--text-muted);">Judul LKP</span><p style="font-weight:500;margin:0;">{{ $seminar->judul_lkp }}</p></div>
            <div><span style="font-size:.78rem;color:var(--text-muted);">Dosen Pembimbing</span><p style="font-weight:500;margin:0;">{{ $seminar->dosen->nama ?? '-' }}</p></div>
            <div><span style="font-size:.78rem;color:var(--text-muted);">Tanggal Daftar</span><p style="font-weight:500;margin:0;">{{ \Carbon\Carbon::parse($seminar->created_at)->format('d M Y') }}</p></div>
            <div><span style="font-size:.78rem;color:var(--text-muted);">Status Jadwal</span>
                <p style="margin:0;">
                    @if($seminar->tanggal_seminar)
                        <span class="status-badge status-approved"><i class="fas fa-check"></i> Terjadwal: {{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->format('d M Y') }}</span>
                    @else
                        <span class="status-badge status-pending"><i class="fas fa-clock"></i> Menunggu Kaprodi</span>
                    @endif
                </p>
            </div>
            <div>
                <span style="font-size:.78rem;color:var(--text-muted);">Laporan LKP</span>
                <p style="margin:.25rem 0 0;"><a href="{{ asset('storage/'.$seminar->file_laporan) }}" target="_blank" style="color:var(--primary-green);font-size:.88rem;"><i class="fas fa-file-pdf"></i> Lihat Laporan</a></p>
            </div>
            <div>
                <span style="font-size:.78rem;color:var(--text-muted);">Bukti Transfer</span>
                <p style="margin:.25rem 0 0;"><a href="{{ asset('storage/'.$seminar->bukti_transfer) }}" target="_blank" style="color:var(--primary-green);font-size:.88rem;"><i class="fas fa-image"></i> Lihat Bukti</a></p>
            </div>
        </div>
    </div>
</div>
@endsection