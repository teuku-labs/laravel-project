<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Bimbingan - Kaprodi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{--primary:#6c5ce7;--dark:#5a4bd1;--light:#f0eeff;--bg:#f8f9fa;--text:#2c3e50;--muted:#6c757d;--sidebar:280px;}
        *{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Poppins',sans-serif;background:var(--bg);color:var(--text);}
        .sidebar{position:fixed;top:0;left:0;width:var(--sidebar);height:100vh;background:linear-gradient(180deg,var(--dark),var(--primary));z-index:1000;overflow-y:auto;}
        .sidebar-header{padding:1.5rem;border-bottom:1px solid rgba(255,255,255,.1);}
        .sidebar-brand{font-size:1.2rem;font-weight:700;color:white;text-decoration:none;display:flex;align-items:center;gap:.75rem;}
        .sidebar-menu{padding:1rem 0;}.menu-cat{padding:.75rem 1.5rem;font-size:.72rem;font-weight:600;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:1px;}
        .menu-item{display:flex;align-items:center;padding:.85rem 1.5rem;color:rgba(255,255,255,.9);text-decoration:none;transition:all .3s;border-left:3px solid transparent;}
        .menu-item:hover,.menu-item.active{background:rgba(255,255,255,.1);color:white;border-left-color:white;}
        .menu-item i{width:22px;margin-right:.75rem;}
        .badge-menu{margin-left:auto;background:rgba(255,255,255,.25);color:white;font-size:.7rem;padding:.2rem .5rem;border-radius:10px;}
        .main{margin-left:var(--sidebar);min-height:100vh;}
        .topbar{background:white;box-shadow:0 2px 15px rgba(0,0,0,.05);padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:999;}
        .toggle-btn{background:none;border:none;font-size:1.3rem;color:var(--text);cursor:pointer;}
        .avatar{width:40px;height:40px;background:linear-gradient(135deg,var(--primary),var(--dark));border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;}
        .content{padding:2rem;}
        .stats-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(155px,1fr));gap:1rem;margin-bottom:1.75rem;}
        .stat-card{background:white;border-radius:12px;padding:1.25rem;box-shadow:0 3px 10px rgba(0,0,0,.05);display:flex;align-items:center;gap:.85rem;}
        .stat-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;}
        .stat-value{font-size:1.6rem;font-weight:700;line-height:1;}.stat-label{font-size:.76rem;color:var(--muted);}
        .section-title{font-weight:600;font-size:.97rem;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;}
        .section-title i{color:var(--primary);}
        .count-badge{margin-left:auto;padding:.2rem .65rem;border-radius:20px;font-size:.72rem;font-weight:600;}
        .count-badge.warning{background:#fff3cd;color:#856404;}
        .count-badge.success{background:var(--light);color:var(--dark);}
        .pengajuan-card{background:white;border-radius:14px;padding:1.25rem 1.5rem;box-shadow:0 4px 15px rgba(0,0,0,.06);border:2px solid #fff3cd;margin-bottom:.85rem;display:flex;align-items:center;gap:1rem;flex-wrap:wrap;}
        .pengajuan-avatar{width:46px;height:46px;background:linear-gradient(135deg,var(--primary),var(--dark));border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:1.1rem;flex-shrink:0;}
        .pengajuan-info{flex:1;min-width:180px;}
        .pengajuan-name{font-weight:600;font-size:.93rem;}
        .pengajuan-detail{font-size:.78rem;color:var(--muted);margin-top:.1rem;}
        .jenis-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .7rem;border-radius:20px;font-size:.73rem;font-weight:600;}
        .jenis-1{background:rgba(108,92,231,.12);color:var(--dark);}
        .jenis-2{background:rgba(52,152,219,.12);color:#2980b9;}
        .btn-approve{background:linear-gradient(135deg,var(--primary),var(--dark));border:none;color:white;padding:.5rem 1.1rem;border-radius:8px;font-size:.82rem;font-weight:600;font-family:'Poppins',sans-serif;cursor:pointer;display:inline-flex;align-items:center;gap:.4rem;transition:all .3s;}
        .btn-approve:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(108,92,231,.4);}
        .btn-reject-link{color:#e74c3c;font-size:.82rem;font-weight:500;cursor:pointer;background:none;border:none;font-family:'Poppins',sans-serif;padding:.5rem .75rem;border-radius:8px;transition:all .3s;}
        .btn-reject-link:hover{background:#fdecea;}
        .table-card{background:white;border-radius:14px;padding:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,.05);margin-bottom:1.5rem;}
        .custom-table{width:100%;border-collapse:collapse;}
        .custom-table thead th{background:var(--light);color:var(--dark);font-weight:600;font-size:.82rem;padding:.85rem 1rem;text-align:left;}
        .custom-table tbody td{padding:.85rem 1rem;border-bottom:1px solid #eee;font-size:.87rem;}
        .custom-table tbody tr:hover{background:var(--light);}
        .badge-p1{background:rgba(108,92,231,.12);color:var(--dark);padding:.25rem .7rem;border-radius:20px;font-size:.72rem;font-weight:500;}
        .badge-p2{background:rgba(52,152,219,.12);color:#2980b9;padding:.25rem .7rem;border-radius:20px;font-size:.72rem;font-weight:500;}
        .badge-approved{background:rgba(39,174,96,.12);color:#1e8449;padding:.25rem .7rem;border-radius:20px;font-size:.72rem;}
        .badge-rejected{background:rgba(231,76,60,.12);color:#c0392b;padding:.25rem .7rem;border-radius:20px;font-size:.72rem;}
        .empty-state{text-align:center;padding:2rem;color:var(--muted);}
        .empty-state i{font-size:2.5rem;color:#dee2e6;margin-bottom:.6rem;}
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.show{transform:translateX(0)}.main{margin-left:0}}
    </style>
</head>
<body>
@include('kaprodi.partials.sidebar')

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;"><button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button><span style="font-weight:600;font-size:.95rem;">Mahasiswa Bimbingan</span></div>
        <div style="display:flex;align-items:center;gap:.75rem;"><div class="avatar">{{ substr($kaprodi->nama ?? 'K', 0, 1) }}</div><div><div style="font-weight:600;font-size:.9rem;">{{ $kaprodi->nama }}</div><div style="font-size:.75rem;color:var(--muted);">Kaprodi</div></div></div>
    </nav>

    <div class="content">
        @if(session('success'))<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if(session('error'))<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif

        <div class="stats-row">
            <div class="stat-card"><div class="stat-icon" style="background:var(--light);color:var(--primary)"><i class="fas fa-user-graduate"></i></div><div><div class="stat-value">{{ $mahasiswaCount }}</div><div class="stat-label">Mahasiswa Bimbingan</div></div></div>
            <div class="stat-card"><div class="stat-icon" style="background:#fff3cd;color:#856404"><i class="fas fa-bell"></i></div><div><div class="stat-value">{{ $pengajuanPending->count() }}</div><div class="stat-label">Permintaan Baru</div></div></div>
            <div class="stat-card"><div class="stat-icon" style="background:rgba(39,174,96,.1);color:#27ae60"><i class="fas fa-check-circle"></i></div><div><div class="stat-value">{{ $riwayatPengajuan->where('status','approved')->count() }}</div><div class="stat-label">Disetujui</div></div></div>
            <div class="stat-card"><div class="stat-icon" style="background:rgba(231,76,60,.1);color:#e74c3c"><i class="fas fa-times-circle"></i></div><div><div class="stat-value">{{ $riwayatPengajuan->where('status','rejected')->count() }}</div><div class="stat-label">Ditolak</div></div></div>
        </div>

        {{-- PENGAJUAN MASUK --}}
        <div class="section-title">
            <i class="fas fa-bell"></i> Permintaan Bimbingan Masuk
            @if($pengajuanPending->count() > 0)<span class="count-badge warning">{{ $pengajuanPending->count() }} baru</span>@endif
        </div>

        @forelse($pengajuanPending as $p)
        @php $jenisRaw = explode('|', $p->catatan)[0]; $jenis = $jenisRaw === 'pembimbing1' ? 'Pembimbing 1' : 'Pembimbing 2'; @endphp
        <div class="pengajuan-card">
            <div class="pengajuan-avatar">{{ substr($p->mahasiswa->nama ?? 'M', 0, 1) }}</div>
            <div class="pengajuan-info">
                <div class="pengajuan-name">{{ $p->mahasiswa->nama }}</div>
                <div class="pengajuan-detail">NIM: {{ $p->mahasiswa->nim ?? '-' }} &nbsp;·&nbsp; {{ $p->mahasiswa->prodi->nama_prodi ?? '-' }}</div>
                <div style="margin-top:.4rem;">
                    <span class="jenis-badge {{ $jenisRaw === 'pembimbing1' ? 'jenis-1' : 'jenis-2' }}">
                        <i class="fas fa-star fa-xs"></i> Mengajukan sebagai {{ $jenis }}
                    </span>
                </div>
                <div style="font-size:.75rem;color:var(--muted);margin-top:.3rem;"><i class="fas fa-clock fa-xs"></i> {{ \Carbon\Carbon::parse($p->created_at)->diffForHumans() }}</div>
            </div>
            <div style="display:flex;flex-direction:column;gap:.5rem;align-items:flex-end;">
                <form action="{{ route('kaprodi.bimbingan.approve', $p->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-approve" onclick="return confirm('Setujui permintaan dari {{ addslashes($p->mahasiswa->nama) }}?')">
                        <i class="fas fa-check"></i> Setujui
                    </button>
                </form>
                <button type="button" class="btn-reject-link" data-bs-toggle="modal" data-bs-target="#rejectModal"
                    data-id="{{ $p->id }}" data-nama="{{ $p->mahasiswa->nama }}">
                    <i class="fas fa-times"></i> Tolak
                </button>
            </div>
        </div>
        @empty
        <div class="table-card" style="padding:2rem;">
            <div class="empty-state"><i class="fas fa-inbox"></i><p>Tidak ada permintaan bimbingan yang menunggu.</p></div>
        </div>
        @endforelse

        {{-- MAHASISWA BIMBINGAN AKTIF --}}
        <div class="section-title" style="margin-top:2rem;">
            <i class="fas fa-user-graduate"></i> Mahasiswa Bimbingan Aktif
            <span class="count-badge success">{{ $mahasiswaCount }}</span>
        </div>
        <div class="table-card">
            <table class="custom-table">
                <thead><tr><th>No</th><th>Nama</th><th>NIM</th><th>Prodi</th><th>Peran</th><th>Status LKP</th></tr></thead>
                <tbody>
                    @forelse($mahasiswaBimbingan as $i => $m)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td><strong>{{ $m->nama }}</strong></td>
                        <td>{{ $m->nim }}</td>
                        <td>{{ $m->prodi->nama_prodi ?? '-' }}</td>
                        <td>
                            @if($m->pembimbing1_id == $kaprodi->user_id)
                                <span class="badge-p1"><i class="fas fa-star fa-xs"></i> Pembimbing 1</span>
                            @else
                                <span class="badge-p2"><i class="fas fa-star-half-alt fa-xs"></i> Pembimbing 2</span>
                            @endif
                        </td>
                        <td>
                            @if($m->seminarLkp)
                                <span class="badge-approved"><i class="fas fa-check"></i> Sudah Daftar</span>
                            @else
                                <span style="color:var(--muted);font-size:.8rem;">Belum</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="fas fa-user-graduate"></i><p>Belum ada mahasiswa bimbingan.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- RIWAYAT --}}
        @if($riwayatPengajuan->count() > 0)
        <div class="section-title"><i class="fas fa-history"></i> Riwayat Pengajuan</div>
        <div class="table-card">
            <table class="custom-table">
                <thead><tr><th>Nama</th><th>NIM</th><th>Prodi</th><th>Peran</th><th>Status</th><th>Waktu</th></tr></thead>
                <tbody>
                    @foreach($riwayatPengajuan as $r)
                    @php $jenisRaw = explode('|', $r->catatan)[0]; @endphp
                    <tr>
                        <td><strong>{{ $r->mahasiswa->nama ?? '-' }}</strong></td>
                        <td>{{ $r->mahasiswa->nim ?? '-' }}</td>
                        <td>{{ $r->mahasiswa->prodi->nama_prodi ?? '-' }}</td>
                        <td>{{ $jenisRaw === 'pembimbing1' ? 'Pembimbing 1' : 'Pembimbing 2' }}</td>
                        <td>
                            @if($r->status === 'approved')
                                <span class="badge-approved"><i class="fas fa-check"></i> Disetujui</span>
                            @else
                                <span class="badge-rejected"><i class="fas fa-times"></i> Ditolak</span>
                            @endif
                        </td>
                        <td style="font-size:.78rem;color:var(--muted);">{{ \Carbon\Carbon::parse($r->updated_at)->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

{{-- Modal Reject --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:14px;border:none;">
            <div class="modal-header" style="background:linear-gradient(135deg,#c0392b,#e74c3c);color:white;border-radius:14px 14px 0 0;">
                <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i> Tolak Permintaan Bimbingan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p style="font-size:.88rem;color:var(--muted);margin-bottom:1rem;">Anda akan menolak permintaan bimbingan dari <strong id="rejectNama"></strong>.</p>
                    <label style="font-size:.85rem;font-weight:500;margin-bottom:.35rem;display:block;">Alasan (opsional)</label>
                    <textarea name="alasan" class="form-control" rows="3" placeholder="Contoh: Kuota bimbingan sudah penuh." style="border-radius:10px;border:2px solid #eee;font-family:'Poppins',sans-serif;font-size:.87rem;"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" style="background:linear-gradient(135deg,#c0392b,#e74c3c);border:none;color:white;padding:.65rem 1.5rem;border-radius:10px;font-weight:600;font-family:'Poppins',sans-serif;cursor:pointer;">
                        <i class="fas fa-times"></i> Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));
    document.getElementById('rejectModal').addEventListener('show.bs.modal', function(e) {
        const btn = e.relatedTarget;
        document.getElementById('rejectNama').textContent = btn.getAttribute('data-nama');
        document.getElementById('rejectForm').action = '/kaprodi/bimbingan/' + btn.getAttribute('data-id') + '/reject';
    });
</script>
</body>
</html>