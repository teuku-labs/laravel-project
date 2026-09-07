@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <a href="{{ route('admin.mahasiswa.index') }}" style="color:var(--primary-green);text-decoration:none;font-size:.9rem;"><i class="fas fa-arrow-left"></i> Kembali</a>
    <h2 style="font-weight:700;margin-top:.5rem;">Detail Mahasiswa</h2>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    <div class="table-card">
        <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.25rem;"><i class="fas fa-user-graduate"></i> Data Pribadi</h5>
        @foreach([['Nama','nama'],['NIM','nim'],['Angkatan','angkatan']] as [$label,$field])
        <div style="display:flex;padding:.75rem 0;border-bottom:1px solid #eee;gap:.75rem;">
            <span style="font-size:.82rem;color:var(--text-muted);min-width:130px;">{{ $label }}</span>
            <span style="font-weight:500;font-size:.9rem;">{{ $mahasiswa->$field ?? '-' }}</span>
        </div>
        @endforeach
        <div style="display:flex;padding:.75rem 0;border-bottom:1px solid #eee;gap:.75rem;">
            <span style="font-size:.82rem;color:var(--text-muted);min-width:130px;">Program Studi</span>
            <span style="font-weight:500;font-size:.9rem;">{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</span>
        </div>
        <div style="display:flex;padding:.75rem 0;border-bottom:1px solid #eee;gap:.75rem;">
            <span style="font-size:.82rem;color:var(--text-muted);min-width:130px;">Email</span>
            <span style="font-weight:500;font-size:.9rem;">{{ $mahasiswa->user->email ?? '-' }}</span>
        </div>
        <div style="display:flex;padding:.75rem 0;gap:.75rem;">
            <span style="font-size:.82rem;color:var(--text-muted);min-width:130px;">Terdaftar</span>
            <span style="font-weight:500;font-size:.9rem;">{{ \Carbon\Carbon::parse($mahasiswa->created_at)->format('d M Y') }}</span>
        </div>
    </div>

    <div class="table-card">
        <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.25rem;"><i class="fas fa-chalkboard-teacher"></i> Dosen Pembimbing</h5>
        <div style="display:flex;padding:.75rem 0;border-bottom:1px solid #eee;gap:.75rem;">
            <span style="font-size:.82rem;color:var(--text-muted);min-width:130px;">Pembimbing 1</span>
            <span style="font-weight:500;font-size:.9rem;">{{ $mahasiswa->pembimbing1->nama ?? '<span style="color:#aaa">Belum dipilih</span>' }}</span>
        </div>
        <div style="display:flex;padding:.75rem 0;border-bottom:1px solid #eee;gap:.75rem;">
            <span style="font-size:.82rem;color:var(--text-muted);min-width:130px;">Pembimbing 2</span>
            <span style="font-weight:500;font-size:.9rem;">{{ $mahasiswa->pembimbing2->nama ?? '<span style="color:#aaa">Belum dipilih</span>' }}</span>
        </div>
        <div style="display:flex;padding:.75rem 0;gap:.75rem;">
            <span style="font-size:.82rem;color:var(--text-muted);min-width:130px;">Seminar LKP</span>
            <span style="font-weight:500;font-size:.9rem;">
                @if($mahasiswa->seminarLkp)
                    <span class="status-badge status-approved"><i class="fas fa-check"></i> Sudah Daftar</span>
                @else
                    <span class="status-badge status-pending"><i class="fas fa-clock"></i> Belum Daftar</span>
                @endif
            </span>
        </div>
    </div>

    @if($mahasiswa->seminarLkp)
    <div class="table-card" style="grid-column:1/-1;">
        <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.25rem;"><i class="fas fa-file-alt"></i> Data Seminar LKP</h5>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            @php $s = $mahasiswa->seminarLkp; @endphp
            @foreach([['Judul LKP','judul_lkp'],['Email','email'],['No HP','no_hp'],['NIK KTP','nik_ktp'],['Tempat Lahir','tempat_lahir']] as [$label,$field])
            <div style="display:flex;flex-direction:column;gap:.25rem;">
                <span style="font-size:.78rem;color:var(--text-muted);">{{ $label }}</span>
                <span style="font-weight:500;font-size:.88rem;">{{ $s->$field ?? '-' }}</span>
            </div>
            @endforeach
            <div style="display:flex;flex-direction:column;gap:.25rem;">
                <span style="font-size:.78rem;color:var(--text-muted);">Status Jadwal</span>
                <span>
                    @if($s->tanggal_seminar)
                        <span class="status-badge status-approved">Terjadwal: {{ \Carbon\Carbon::parse($s->tanggal_seminar)->format('d M Y') }}</span>
                    @else
                        <span class="status-badge status-pending">Menunggu Jadwal</span>
                    @endif
                </span>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection