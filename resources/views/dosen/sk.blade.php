<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download SK - Dosen Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary-green:#2ecc71; --dark-green:#27ae60; --light-green:#e8f8f0; --bg-color:#f8f9fa; --text-dark:#2c3e50; --text-muted:#6c757d; --sidebar-width:280px; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Poppins',sans-serif; background-color:var(--bg-color); color:var(--text-dark); }
        .sidebar { position:fixed; top:0; left:0; width:var(--sidebar-width); height:100vh; background:linear-gradient(180deg,var(--dark-green) 0%,var(--primary-green) 100%); z-index:1000; overflow-y:auto; }
        .sidebar-header { padding:1.5rem; border-bottom:1px solid rgba(255,255,255,0.1); }
        .sidebar-brand { font-size:1.3rem; font-weight:700; color:white; text-decoration:none; display:flex; align-items:center; gap:0.75rem; }
        .sidebar-menu { padding:1rem 0; }
        .menu-category { padding:0.75rem 1.5rem; font-size:0.75rem; font-weight:600; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:1px; }
        .menu-item { display:flex; align-items:center; padding:0.85rem 1.5rem; color:rgba(255,255,255,0.9); text-decoration:none; transition:all 0.3s; border-left:3px solid transparent; }
        .menu-item:hover,.menu-item.active { background:rgba(255,255,255,0.1); color:white; border-left-color:white; }
        .menu-item i { width:25px; margin-right:0.75rem; }
        .menu-item .badge { margin-left:auto; background:rgba(255,255,255,0.2); color:white; font-size:0.7rem; padding:0.25rem 0.5rem; border-radius:10px; }
        .main-wrapper { margin-left:var(--sidebar-width); min-height:100vh; }
        .top-navbar { background:white; box-shadow:0 2px 15px rgba(0,0,0,0.05); padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; position:sticky; top:0; z-index:999; }
        .sidebar-toggle { background:none; border:none; font-size:1.3rem; color:var(--text-dark); cursor:pointer; }
        .user-avatar { width:40px; height:40px; background:linear-gradient(135deg,var(--primary-green),var(--dark-green)); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:600; }
        .user-info .name { font-weight:600; font-size:0.9rem; }
        .user-info .role { font-size:0.75rem; color:var(--text-muted); }
        .content-area { padding:2rem; }
        .page-header { margin-bottom:2rem; }
        .page-header h2 { font-weight:700; }
        .page-header p { color:var(--text-muted); font-size:0.9rem; }
        .stats-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:1rem; margin-bottom:2rem; }
        .stat-mini { background:white; border-radius:12px; padding:1rem; box-shadow:0 3px 10px rgba(0,0,0,0.05); text-align:center; }
        .stat-mini .value { font-size:1.8rem; font-weight:700; color:var(--text-dark); }
        .stat-mini .label { font-size:0.8rem; color:var(--text-muted); }
        .documents-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:1.5rem; }
        .document-card { background:white; border-radius:16px; padding:1.5rem; box-shadow:0 5px 20px rgba(0,0,0,0.05); border:1px solid #eee; transition:all 0.3s; display:flex; flex-direction:column; }
        .document-card:hover { transform:translateY(-5px); box-shadow:0 10px 30px rgba(0,0,0,0.1); border-color:var(--primary-green); }
        .document-icon { width:60px; height:60px; background:var(--light-green); border-radius:14px; display:flex; align-items:center; justify-content:center; color:var(--dark-green); font-size:1.5rem; margin-bottom:1rem; }
        .document-title { font-weight:600; font-size:1rem; margin-bottom:0.5rem; }
        .document-info { font-size:0.85rem; color:var(--text-muted); margin-bottom:1rem; flex:1; }
        .document-info p { margin:0.25rem 0; display:flex; align-items:center; gap:0.5rem; }
        .document-info i { color:var(--primary-green); font-size:0.75rem; }
        .btn-download { background:linear-gradient(135deg,var(--primary-green),var(--dark-green)); border:none; color:white; padding:0.75rem; border-radius:10px; font-weight:500; width:100%; transition:all 0.3s; display:flex; align-items:center; justify-content:center; gap:0.5rem; text-decoration:none; font-family:'Poppins',sans-serif; cursor:pointer; }
        .btn-download:hover { transform:translateY(-2px); box-shadow:0 5px 15px rgba(46,204,113,0.4); color:white; }
        .btn-download.disabled { background:#e9ecef; color:#adb5bd; cursor:not-allowed; }
        .btn-download.disabled:hover { transform:none; box-shadow:none; }
        .empty-state { text-align:center; padding:3rem 1rem; color:var(--text-muted); }
        .empty-state i { font-size:4rem; color:#dee2e6; margin-bottom:1rem; }
        .empty-state h5 { color:var(--text-dark); margin-bottom:0.5rem; }
        @media(max-width:992px){ .sidebar{transform:translateX(-100%);} .sidebar.show{transform:translateX(0);} .main-wrapper{margin-left:0;} }
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand"><i class="fas fa-chalkboard-teacher"></i><span>Dosen Portal</span></a>
        </div>
        <nav class="sidebar-menu">
            <div class="menu-category">Menu Utama</div>
            <a href="{{ route('dosen.dashboard') }}" class="menu-item"><i class="fas fa-home"></i><span>Dashboard</span></a>
            <a href="{{ route('dosen.jadwal') }}" class="menu-item"><i class="fas fa-calendar-alt"></i><span>Jadwal Saya</span>@if($upcomingJadwal > 0)<span class="badge">{{ $upcomingJadwal }}</span>@endif</a>
            <a href="{{ route('dosen.sk') }}" class="menu-item active"><i class="fas fa-file-download"></i><span>Download SK</span></a>
            <a href="{{ route('dosen.mahasiswa') }}" class="menu-item"><i class="fas fa-user-graduate"></i><span>Mahasiswa Bimbingan</span>@if($mahasiswaCount > 0)<span class="badge">{{ $mahasiswaCount }}</span>@endif</a>
            <div class="menu-category" style="margin-top:1.5rem;">Penilaian</div>
            <a href="{{ route('dosen.nilai-lkp.index') }}" class="menu-item"><i class="fas fa-star-half-alt"></i><span>Nilai Seminar LKP</span></a>
            <a href="{{ route('dosen.nilai-proposal.index') }}" class="menu-item"><i class="fas fa-star-half-alt"></i><span>Nilai Seminar Proposal</span></a>
            <a href="{{ route('dosen.nilai-sidang.index') }}" class="menu-item"><i class="fas fa-star-half-alt"></i><span>Nilai Sidang Skripsi</span></a>
            <div class="menu-category" style="margin-top:2rem;">Lainnya</div>
            <a href="{{ route('dosen.profile') }}" class="menu-item"><i class="fas fa-user"></i><span>Profil Saya</span></a>
            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="menu-item" style="width:100%;text-align:left;background:none;border:none;color:inherit;"><i class="fas fa-sign-out-alt"></i><span>Logout</span></button></form>
        </nav>
    </aside>

    <div class="main-wrapper">
        <nav class="top-navbar">
            <div style="display:flex;align-items:center;gap:1rem;">
                <button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                <span style="color:var(--text-muted);font-size:0.9rem;">Download SK</span>
            </div>
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <div class="user-avatar">{{ substr($dosen->nama ?? 'D', 0, 1) }}</div>
                <div class="user-info"><div class="name">{{ $dosen->nama ?? '-' }}</div><div class="role">Dosen</div></div>
            </div>
        </nav>

        <div class="content-area">
            <div class="page-header">
                <h2><i class="fas fa-file-download" style="color:var(--primary-green);"></i> Surat Keputusan (SK)</h2>
                <p>SK yang tersedia untuk didownload</p>
            </div>

            <div class="stats-row">
                <div class="stat-mini">
                    <div class="value">{{ $skCount }}</div>
                    <div class="label">Total SK</div>
                </div>
                <div class="stat-mini">
                    <div class="value" style="color:var(--dark-green);">{{ $skDocuments->where('status','approved')->count() }}</div>
                    <div class="label">Disetujui</div>
                </div>
                <div class="stat-mini">
                    <div class="value" style="color:#f39c12;">{{ $pendingApproval }}</div>
                    <div class="label">Pending</div>
                </div>
            </div>

            <div class="documents-grid">
                @forelse($skDocuments as $sk)
                    <div class="document-card">
                        <div class="document-icon"><i class="fas fa-file-pdf"></i></div>
                        <div class="document-title">{{ $sk->jenis ?? 'SK Pembimbing' }}</div>
                        <div class="document-info">
                            <p><i class="fas fa-hashtag"></i> {{ $sk->nomor_sk ?? 'Belum ada nomor' }}</p>
                            <p><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($sk->created_at)->format('d M Y') }}</p>
                            <p><i class="fas fa-check-circle"></i>
                                @if($sk->status == 'approved')
                                    <span style="color:var(--dark-green);">Disetujui</span>
                                @elseif($sk->status == 'pending')
                                    <span style="color:#f39c12;">Menunggu Persetujuan</span>
                                @else
                                    <span style="color:#e74c3c;">Ditolak</span>
                                @endif
                            </p>
                        </div>
                        @if(isset($sk->file_path) && $sk->file_path && $sk->status == 'approved')
                            <a href="{{ asset('storage/' . $sk->file_path) }}" class="btn-download" download>
                                <i class="fas fa-download"></i> Download SK
                            </a>
                        @else
                            <button class="btn-download disabled" disabled>
                                <i class="fas fa-lock"></i> Belum Tersedia
                            </button>
                        @endif
                    </div>
                @empty
                    <div style="grid-column:1/-1;">
                        <div class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            <h5>Belum Ada SK</h5>
                            <p>SK akan muncul di sini setelah disetujui oleh Kaprodi/Dekan.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
</body>
</html>