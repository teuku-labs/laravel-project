<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seminar LKP - Dekan</title>
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
        .avatar{width:40px;height:40px;background:linear-gradient(135deg,var(--primary),var(--dark));border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;}
        .content{padding:2rem;}
        .table-card{background:white;border-radius:16px;padding:1.5rem;box-shadow:0 5px 20px rgba(0,0,0,.05);}
        .table-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;flex-wrap:wrap;gap:1rem;}
        .search-box{position:relative;min-width:250px;}
        .search-box input{padding:.7rem 1rem .7rem 2.4rem;border:2px solid #eee;border-radius:10px;width:100%;font-family:'Poppins',sans-serif;font-size:.88rem;}
        .search-box input:focus{border-color:var(--primary);outline:none;}
        .search-box i{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:var(--muted);}
        .custom-table{width:100%;border-collapse:collapse;}
        .custom-table thead th{background:var(--light);color:var(--dark);font-weight:600;font-size:.83rem;padding:.85rem 1rem;text-align:left;}
        .custom-table tbody td{padding:.85rem 1rem;border-bottom:1px solid #eee;font-size:.88rem;}
        .custom-table tbody tr:hover{background:var(--light);}
        .badge-pending{background:rgba(243,156,18,.15);color:#d68910;padding:.3rem .8rem;border-radius:20px;font-size:.73rem;font-weight:500;}
        .badge-done{background:rgba(39,174,96,.15);color:#1e8449;padding:.3rem .8rem;border-radius:20px;font-size:.73rem;font-weight:500;}
        .empty-state{text-align:center;padding:2.5rem;color:var(--muted);}
        .empty-state i{font-size:3rem;color:#dee2e6;margin-bottom:.75rem;}
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.show{transform:translateX(0)}.main{margin-left:0}}
    </style>
</head>
<body>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header"><a href="#" class="sidebar-brand"><i class="fas fa-user-shield"></i><span>Dekan Panel</span></a></div>
    <nav class="sidebar-menu">
        <div class="menu-cat">Menu Utama</div>
        <a href="{{ route('dekan.dashboard') }}" class="menu-item"><i class="fas fa-home"></i>Dashboard</a>
        <a href="{{ route('dekan.seminar') }}" class="menu-item active"><i class="fas fa-file-alt"></i>Seminar LKP</a>
        <a href="{{ route('dekan.jadwal') }}" class="menu-item"><i class="fas fa-calendar-alt"></i>Jadwal Seminar</a>
        <a href="{{ route('dekan.proposal') }}" class="menu-item"><i class="fas fa-file-contract"></i>Proposal</a>
        <a href="{{ route('dekan.sidang') }}" class="menu-item"><i class="fas fa-user-graduate"></i>Sidang</a>
        <div class="menu-cat" style="margin-top:1.5rem;">Lainnya</div>
        <a href="{{ route('dekan.profile') }}" class="menu-item"><i class="fas fa-user"></i>Profil Saya</a>
        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="menu-item" style="width:100%;text-align:left;background:none;border:none;color:inherit;"><i class="fas fa-sign-out-alt"></i>Logout</button></form>
    </nav>
</aside>
<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;"><button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button><span style="color:var(--muted);font-size:.9rem;">Seminar LKP</span></div>
        <div style="display:flex;align-items:center;gap:.75rem;"><div class="avatar">{{ substr($dekan->nama ?? 'D', 0, 1) }}</div><div><div style="font-weight:600;font-size:.9rem;">{{ $dekan->nama }}</div><div style="font-size:.75rem;color:var(--muted);">Dekan</div></div></div>
    </nav>
    <div class="content">
        <div class="table-card">
            <div class="table-header">
                <div><strong style="font-size:1rem;">Semua Pendaftar Seminar LKP</strong><p style="color:var(--muted);font-size:.83rem;margin:0;">Total: {{ $seminarList->count() }} pendaftar</p></div>
                <div class="search-box"><i class="fas fa-search"></i><input type="text" id="searchInput" placeholder="Cari mahasiswa..."></div>
            </div>
            <div class="table-responsive">
                <table class="custom-table" id="seminarTable">
                    <thead><tr><th>No</th><th>Nama</th><th>NIM</th><th>Prodi</th><th>Judul LKP</th><th>Pembimbing</th><th>Tanggal Daftar</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($seminarList as $i => $s)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><strong>{{ $s->mahasiswa->nama ?? '-' }}</strong></td>
                            <td>{{ $s->mahasiswa->nim ?? '-' }}</td>
                            <td>{{ $s->mahasiswa->prodi->nama ?? '-' }}</td>
                            <td>{{ Str::limit($s->judul_lkp, 35) }}</td>
                            <td>{{ $s->dosen->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($s->created_at)->format('d M Y') }}</td>
                            <td>@if($s->tanggal_seminar)<span class="badge-done"><i class="fas fa-check"></i> Terjadwal</span>@else<span class="badge-pending"><i class="fas fa-clock"></i> Menunggu</span>@endif</td>
                        </tr>
                        @empty
                        <tr><td colspan="8"><div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada pendaftaran seminar LKP.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));
    document.getElementById('searchInput').addEventListener('input',function(){const q=this.value.toLowerCase();document.querySelectorAll('#seminarTable tbody tr').forEach(r=>{r.style.display=r.textContent.toLowerCase().includes(q)?'':'none';});});
</script>
</body>
</html>