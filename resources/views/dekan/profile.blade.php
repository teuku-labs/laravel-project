<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Dekan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{--primary:#e17055;--dark:#c0392b;--light:#fdf0ee;--bg:#f8f9fa;--text:#2c3e50;--muted:#6c757d;--sidebar:280px;}
        *{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Poppins',sans-serif;background:var(--bg);color:var(--text);}
        .sidebar{position:fixed;top:0;left:0;width:var(--sidebar);height:100vh;background:linear-gradient(180deg,var(--dark),var(--primary));z-index:1000;overflow-y:auto;}
        .sidebar-header{padding:1.5rem;border-bottom:1px solid rgba(255,255,255,0.1);}
        .sidebar-brand{font-size:1.2rem;font-weight:700;color:white;text-decoration:none;display:flex;align-items:center;gap:.75rem;}
        .sidebar-menu{padding:1rem 0;}.menu-cat{padding:.75rem 1.5rem;font-size:.72rem;font-weight:600;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:1px;}
        .menu-item{display:flex;align-items:center;padding:.85rem 1.5rem;color:rgba(255,255,255,.9);text-decoration:none;transition:all .3s;border-left:3px solid transparent;}
        .menu-item:hover,.menu-item.active{background:rgba(255,255,255,.1);color:white;border-left-color:white;}
        .menu-item i{width:22px;margin-right:.75rem;}
        .main{margin-left:var(--sidebar);min-height:100vh;}
        .topbar{background:white;box-shadow:0 2px 15px rgba(0,0,0,.05);padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:999;}
        .toggle-btn{background:none;border:none;font-size:1.3rem;color:var(--text);cursor:pointer;}
        .content{padding:2rem;}
        .profile-card{background:white;border-radius:16px;padding:2rem;box-shadow:0 5px 20px rgba(0,0,0,.05);max-width:560px;margin:0 auto 1.5rem;}
        .profile-avatar{width:90px;height:90px;background:linear-gradient(135deg,var(--primary),var(--dark));border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:2.2rem;font-weight:700;margin:0 auto 1rem;}
        .profile-name{text-align:center;font-size:1.4rem;font-weight:700;margin-bottom:.2rem;}
        .profile-role{text-align:center;color:var(--muted);font-size:.88rem;margin-bottom:1.75rem;}
        .info-row{display:flex;align-items:center;padding:.85rem 0;border-bottom:1px solid #eee;gap:.85rem;}
        .info-row:last-child{border-bottom:none;}
        .info-icon{width:38px;height:38px;background:var(--light);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--primary);flex-shrink:0;}
        .info-label{font-size:.78rem;color:var(--muted);margin-bottom:.1rem;}
        .info-value{font-weight:500;font-size:.9rem;}
        .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.5rem;max-width:560px;margin:0 auto;}
        .stat-card{background:white;border-radius:16px;padding:1.5rem;box-shadow:0 5px 20px rgba(0,0,0,.05);display:flex;align-items:center;gap:1rem;}
        .stat-icon{width:50px;height:50px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;background:var(--light);color:var(--primary);}
        .stat-value{font-size:1.6rem;font-weight:700;line-height:1;}.stat-label{font-size:.8rem;color:var(--muted);margin-top:.25rem;}
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.show{transform:translateX(0)}.main{margin-left:0}}
    </style>
</head>
<body>
@include('dekan.partials.sidebar')

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;"><button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button><span style="color:var(--muted);font-size:.9rem;">Profil Saya</span></div>
    </nav>
    <div class="content">
        <div class="profile-card">
            <div class="profile-avatar">{{ substr($dekan->nama ?? 'D', 0, 1) }}</div>
            <div class="profile-name">{{ $dekan->nama }}</div>
            <div class="profile-role"><i class="fas fa-user-shield"></i> Dekan</div>
            <div class="info-row"><div class="info-icon"><i class="fas fa-id-card"></i></div><div><div class="info-label">NUPTK</div><div class="info-value">{{ $dekan->nuptk ?? '-' }}</div></div></div>
            <div class="info-row"><div class="info-icon"><i class="fas fa-envelope"></i></div><div><div class="info-label">Email</div><div class="info-value">{{ $dekan->user->email ?? '-' }}</div></div></div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-book"></i></div>
                <div>
                    <div class="info-label">Program Studi</div>
                    <div class="info-value">{{ $dekan->prodi?->nama_prodi ?? '-' }}</div>
                </div>
            </div>
            <div class="info-row"><div class="info-icon"><i class="fas fa-calendar"></i></div><div><div class="info-label">Terdaftar Sejak</div><div class="info-value">{{ \Carbon\Carbon::parse($dekan->created_at)->format('d M Y') }}</div></div></div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div><div class="stat-value">{{ $mahasiswaBimbingan }}</div><div class="stat-label">Mahasiswa Bimbingan</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div><div class="stat-value">{{ $pengajuanBaru }}</div><div class="stat-label">Pengajuan Baru</div></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>document.getElementById('sidebarToggle').addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));</script>
</body>
</html>