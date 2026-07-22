<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Dosen Portal</title>
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
        .content-area { padding:2rem; }
        .profile-card { background:white; border-radius:16px; padding:2rem; box-shadow:0 5px 20px rgba(0,0,0,0.05); max-width:600px; margin:0 auto; }
        .profile-avatar { width:100px; height:100px; background:linear-gradient(135deg,var(--primary-green),var(--dark-green)); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:2.5rem; font-weight:700; margin:0 auto 1.5rem; }
        .profile-name { text-align:center; font-size:1.5rem; font-weight:700; margin-bottom:0.25rem; }
        .profile-role { text-align:center; color:var(--text-muted); font-size:0.9rem; margin-bottom:2rem; }
        .info-row { display:flex; align-items:center; padding:1rem 0; border-bottom:1px solid #eee; gap:1rem; }
        .info-row:last-child { border-bottom:none; }
        .info-icon { width:40px; height:40px; background:var(--light-green); border-radius:10px; display:flex; align-items:center; justify-content:center; color:var(--dark-green); flex-shrink:0; }
        .info-label { font-size:0.8rem; color:var(--text-muted); margin-bottom:0.1rem; }
        .info-value { font-weight:500; font-size:0.95rem; }
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
            <a href="{{ route('dosen.sk') }}" class="menu-item"><i class="fas fa-file-download"></i><span>Download SK</span></a>
            <a href="{{ route('dosen.mahasiswa') }}" class="menu-item"><i class="fas fa-user-graduate"></i><span>Mahasiswa Bimbingan</span>@if($mahasiswaCount > 0)<span class="badge">{{ $mahasiswaCount }}</span>@endif</a>
            <div class="menu-category" style="margin-top:2rem;">Lainnya</div>
            <a href="{{ route('dosen.profile') }}" class="menu-item active"><i class="fas fa-user"></i><span>Profil Saya</span></a>
            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="menu-item" style="width:100%;text-align:left;background:none;border:none;color:inherit;"><i class="fas fa-sign-out-alt"></i><span>Logout</span></button></form>
        </nav>
    </aside>

    <div class="main-wrapper">
        <nav class="top-navbar">
            <div style="display:flex;align-items:center;gap:1rem;">
                <button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                <span style="color:var(--text-muted);font-size:0.9rem;">Profil Saya</span>
            </div>
        </nav>

        <div class="content-area">
            <div class="profile-card">
                <div class="profile-avatar">{{ substr($dosen->nama ?? 'D', 0, 1) }}</div>
                <div class="profile-name">{{ $dosen->nama ?? '-' }}</div>
                <div class="profile-role"><i class="fas fa-chalkboard-teacher"></i> Dosen</div>

                <div class="info-row">
                    <div class="info-icon"><i class="fas fa-id-card"></i></div>
                    <div>
                        <div class="info-label">NUPTK</div>
                        <div class="info-value">{{ $dosen->nuptk ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $dosen->user->email ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-icon"><i class="fas fa-book"></i></div>
                    <div>
                        <div class="info-label">Program Studi</div>
                        <div class="info-value">{{ $dosen->prodi->nama ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-icon"><i class="fas fa-user-graduate"></i></div>
                    <div>
                        <div class="info-label">Jumlah Mahasiswa Bimbingan</div>
                        <div class="info-value">{{ $mahasiswaCount }} Mahasiswa</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-icon"><i class="fas fa-calendar"></i></div>
                    <div>
                        <div class="info-label">Terdaftar Sejak</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($dosen->created_at)->format('d M Y') }}</div>
                    </div>
                </div>
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