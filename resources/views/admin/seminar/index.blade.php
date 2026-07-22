@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <h2 style="font-weight:700;">Seminar LKP</h2>
    <p style="color:var(--text-muted);font-size:.9rem;">Daftar semua pendaftaran seminar LKP mahasiswa</p>
</div>

<div class="stats-grid" style="margin-bottom:2rem;">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
        <div class="stat-content"><div class="label">Total Pendaftar</div><div class="value">{{ $totalSeminar }}</div></div>
    </div>
    <div class="stat-card warning">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-content"><div class="label">Belum Dijadwal</div><div class="value">{{ $pending }}</div></div>
    </div>
    <div class="stat-card info">
        <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
        <div class="stat-content"><div class="label">Sudah Dijadwal</div><div class="value">{{ $terjadwal }}</div></div>
    </div>
</div>

<div class="table-card">
    <div class="table-header" style="flex-wrap:wrap;gap:1rem;">
        <div class="table-title"><i class="fas fa-clipboard-list"></i> Daftar Seminar LKP</div>
        <form method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari mahasiswa / NIM..." class="form-control" style="width:220px;">
            <select name="status" class="form-select" style="width:160px;">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Belum Dijadwal</option>
                <option value="terjadwal" {{ request('status')=='terjadwal'?'selected':'' }}>Sudah Dijadwal</option>
            </select>
            <button type="submit" style="background:var(--primary-green);color:white;border:none;padding:.5rem 1rem;border-radius:8px;cursor:pointer;"><i class="fas fa-search"></i></button>
            @if(request()->anyFilled(['search','status']))<a href="{{ route('admin.seminar.index') }}" style="background:#eee;color:#333;padding:.5rem 1rem;border-radius:8px;text-decoration:none;">Reset</a>@endif
        </form>
    </div>
    <div class="table-responsive">
        <table class="custom-table">
            <thead><tr><th>No</th><th>Mahasiswa</th><th>NIM</th><th>Judul LKP</th><th>Pembimbing</th><th>Daftar</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($seminars as $i => $s)
                <tr>
                    <td>{{ $seminars->firstItem() + $i }}</td>
                    <td><strong>{{ $s->mahasiswa->nama ?? '-' }}</strong></td>
                    <td>{{ $s->mahasiswa->nim ?? '-' }}</td>
                    <td>{{ Str::limit($s->judul_lkp, 35) }}</td>
                    <td>{{ $s->dosen->nama ?? '-' }}</td>
                    <td style="font-size:.82rem;color:var(--text-muted);">{{ \Carbon\Carbon::parse($s->created_at)->format('d M Y') }}</td>
                    <td>
                        @if($s->tanggal_seminar)
                            <span class="status-badge status-approved"><i class="fas fa-check"></i> Terjadwal</span>
                        @else
                            <span class="status-badge status-pending"><i class="fas fa-clock"></i> Pending</span>
                        @endif
                    </td>
                    <td><a href="{{ route('admin.seminar.show', $s->id) }}" class="action-btn view"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted"><i class="fas fa-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1rem;">{{ $seminars->links() }}</div>
</div>
@endsection