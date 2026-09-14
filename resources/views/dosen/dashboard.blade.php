<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #2ecc71;
            --dark-green: #27ae60;
            --light-green: #e8f8f0;
            --bg-color: #f8f9fa;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --sidebar-width: 280px;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--dark-green) 0%, var(--primary-green) 100%);
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand {
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sidebar-menu { padding: 1rem 0; }
        
        .menu-category {
            padding: 0.75rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .menu-item:hover, .menu-item.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: white;
        }
        
        .menu-item i {
            width: 25px;
            margin-right: 0.75rem;
        }
        
        .menu-item .badge {
            margin-left: auto;
            background: rgba(255,255,255,0.2);
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
        }
        
        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        .top-navbar {
            background: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .navbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.3rem;
            color: var(--text-dark);
            cursor: pointer;
        }
        
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .user-info .name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
        }
        
        .user-info .role {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        
        .content-area { padding: 2rem; }
        
        /* Info Banner */
        .info-banner {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            border-radius: 16px;
            padding: 1.5rem 2rem;
            color: white;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 10px 30px rgba(46, 204, 113, 0.25);
        }
        
        .info-banner i {
            font-size: 2rem;
            opacity: 0.9;
        }
        
        .info-banner .content h4 {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .info-banner .content p {
            opacity: 0.95;
            font-size: 0.9rem;
            margin: 0;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
            border-left: 4px solid var(--primary-green);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .stat-card.warning { border-left-color: #f39c12; }
        .stat-card.info { border-left-color: #3498db; }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            background: var(--light-green);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-green);
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        
        .stat-card.warning .stat-icon { background: #fef5e7; color: #f39c12; }
        .stat-card.info .stat-icon { background: #ebf5fb; color: #3498db; }
        
        .stat-content .label {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        
        .stat-content .value {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-dark);
        }
        
        /* Section Title */
        .section-title {
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .section-title i {
            color: var(--primary-green);
        }
        
        /* Schedule Table Card */
        .table-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .search-box {
            position: relative;
            min-width: 250px;
        }
        
        .search-box input {
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid #eee;
            border-radius: 10px;
            width: 100%;
        }
        
        .search-box input:focus {
            border-color: var(--primary-green);
            outline: none;
        }
        
        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        
        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .custom-table thead th {
            background: var(--light-green);
            color: var(--dark-green);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 1rem;
            text-align: left;
        }
        
        .custom-table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            font-size: 0.9rem;
        }
        
        .custom-table tbody tr:hover {
            background: var(--light-green);
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-upcoming {
            background: rgba(52, 152, 219, 0.15);
            color: #3498db;
        }
        
        .status-completed {
            background: rgba(46, 204, 113, 0.15);
            color: var(--dark-green);
        }
        
        .status-pending {
            background: rgba(243, 156, 18, 0.15);
            color: #f39c12;
        }
        
        /* SK Documents Grid */
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .document-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border: 1px solid #eee;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .document-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-color: var(--primary-green);
        }
        
        .document-icon {
            width: 60px;
            height: 60px;
            background: var(--light-green);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-green);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .document-title {
            font-weight: 600;
            font-size: 1rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .document-info {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
            flex: 1;
        }
        
        .document-info p {
            margin: 0.25rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .document-info i {
            color: var(--primary-green);
            font-size: 0.75rem;
        }
        
        .btn-download {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            border: none;
            color: white;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        
        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.4);
            color: white;
        }
        
        .btn-download.disabled {
            background: #e9ecef;
            color: #adb5bd;
            cursor: not-allowed;
        }
        
        .btn-download.disabled:hover {
            transform: none;
            box-shadow: none;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }
        
        .empty-state h5 {
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
        }
        
        @media (max-width: 768px) {
            .content-area { padding: 1rem; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .documents-grid { grid-template-columns: 1fr; }
            .table-header { flex-direction: column; align-items: stretch; }
            .search-box { min-width: 100%; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Dosen Portal</span>
            </a>
        </div>
        
        <nav class="sidebar-menu">
            <div class="menu-category">Menu Utama</div>
            
            <a href="{{ route('dosen.dashboard') }}" class="menu-item active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('dosen.jadwal') }}" class="menu-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Jadwal Saya</span>
                @if($upcomingJadwal ?? 0 > 0)
                    <span class="badge">{{ $upcomingJadwal }}</span>
                @endif
            </a>
            
            <a href="{{ route('dosen.sk') }}" class="menu-item">
                <i class="fas fa-file-download"></i>
                <span>Download SK</span>
            </a>
            
            <a href="{{ route('dosen.mahasiswa') }}" class="menu-item">
                <i class="fas fa-user-graduate"></i>
                <span>Mahasiswa Bimbingan</span>
                @if($mahasiswaCount ?? 0 > 0)
                    <span class="badge">{{ $mahasiswaCount }}</span>
                @endif
            </a>

            <div class="menu-category" style="margin-top: 2rem;">Penilaian</div>

            <a href="{{ route('dosen.nilai-lkp.index') }}" class="menu-item">
                <i class="fas fa-star-half-alt"></i>
                <span>Nilai Seminar LKP</span>
            </a>

            <a href="{{ route('dosen.nilai-proposal.index') }}" class="menu-item">
                <i class="fas fa-star-half-alt"></i>
                <span>Nilai Seminar Proposal</span>
            </a>

            <a href="{{ route('dosen.nilai-sidang.index') }}" class="menu-item">
                <i class="fas fa-star-half-alt"></i>
                <span>Nilai Sidang Skripsi</span>
            </a>
            
            <div class="menu-category" style="margin-top: 2rem;">Lainnya</div>
            
            <a href="{{ route('dosen.profile') }}" class="menu-item">
                <i class="fas fa-user"></i>
                <span>Profil Saya</span>
            </a>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="menu-item" style="width: 100%; text-align: left; background: none; border: none; color: inherit;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper" id="mainWrapper">
        
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="navbar-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="text-muted">
                    <span>Dashboard</span>
                </div>
            </div>
            
            <div class="navbar-right">
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ substr($dosen->nama ?? Auth::user()->name ?? 'D', 0, 1) }}
                    </div>
                    <div class="user-info">
                        <div class="name">{{ $dosen->nama ?? Auth::user()->name }}</div>
                        <div class="role">Dosen</div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content-area">
            
            <!-- Info Banner -->
            <div class="info-banner">
                <i class="fas fa-info-circle"></i>
                <div class="content">
                    <h4>Selamat Datang, {{ $dosen->nama ?? 'Dosen' }}!</h4>
                    <p>Anda dapat melihat jadwal mengajar dan mendownload SK pembimbing di dashboard ini.</p>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <div class="label">Jadwal Mendatang</div>
                        <div class="value">{{ $upcomingJadwal ?? 0 }}</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <div class="stat-content">
                        <div class="label">SK Tersedia</div>
                        <div class="value">{{ $skCount ?? 0 }}</div>
                    </div>
                </div>
                
                <div class="stat-card info">
                    <div class="stat-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-content">
                        <div class="label">Mahasiswa Bimbingan</div>
                        <div class="value">{{ $mahasiswaCount ?? 0 }}</div>
                    </div>
                </div>
                
                <div class="stat-card warning">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <div class="label">Menunggu Approval</div>
                        <div class="value">{{ $pendingApproval ?? 0 }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Jadwal Section -->
            <h5 class="section-title">
                <i class="fas fa-calendar-alt"></i>
                <span>Jadwal Seminar & Sidang</span>
            </h5>
            
            <div class="table-card">
                <div class="table-header">
                    <div>
                        <strong>Daftar Jadwal</strong>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Jadwal dimana Anda bertugas sebagai pembimbing atau penguji</p>
                    </div>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchJadwal" placeholder="Cari jadwal...">
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="custom-table" id="jadwalTable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Tanggal</th>
                                <th width="15%">Waktu</th>
                                <th width="20%">Mahasiswa</th>
                                <th width="15%">Jenis</th>
                                <th width="15%">Ruang</th>
                                <th width="15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwals as $index => $jadwal)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</strong>
                                    </td>
                                    <td>{{ $jadwal->waktu ? $jadwal->waktu . ($jadwal->waktu_selesai ? ' - ' . $jadwal->waktu_selesai : '') : '-' }}</td>
                                    <td>
                                        <div>
                                            <strong>{{ $jadwal->mahasiswa->nama ?? '-' }}</strong><br>
                                            <small class="text-muted">{{ $jadwal->mahasiswa->nim ?? '-' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($jadwal->jenis == 'lkp')
                                            <span class="status-badge status-upcoming">
                                                <i class="fas fa-briefcase"></i> Seminar LKP
                                            </span>
                                        @elseif($jadwal->jenis == 'proposal')
                                            <span class="status-badge status-pending">
                                                <i class="fas fa-file-alt"></i> Seminar Proposal
                                            </span>
                                        @elseif($jadwal->jenis == 'sidang')
                                            <span class="status-badge status-completed">
                                                <i class="fas fa-graduation-cap"></i> Sidang Skripsi
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $jadwal->ruang ?? '-' }}</td>
                                    <td>
                                        @if(\Carbon\Carbon::parse($jadwal->tanggal)->isFuture())
                                            <span class="status-badge status-upcoming">
                                                <i class="fas fa-clock"></i> Akan Datang
                                            </span>
                                        @else
                                            <span class="status-badge status-completed">
                                                <i class="fas fa-check"></i> Selesai
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-times"></i>
                                            <h5>Belum Ada Jadwal</h5>
                                            <p>Anda belum memiliki jadwal seminar atau sidang yang terjadwal.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- SK Documents Section -->
            <h5 class="section-title">
                <i class="fas fa-file-download"></i>
                <span>Surat Keputusan (SK)</span>
            </h5>
            
            <div class="documents-grid">
                @forelse($skDocuments as $sk)
                    <div class="document-card">
                        <div class="document-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="document-title">{{ $sk->jenis ?? 'SK Pembimbing' }}</div>
                        <div class="document-info">
                            <p><i class="fas fa-user-graduate"></i> {{ $sk->mahasiswa_nama ?? '-' }}</p>
                            <p><i class="fas fa-id-card"></i> {{ $sk->mahasiswa_nim ?? '-' }}</p>
                            <p><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($sk->created_at)->format('d M Y') }}</p>
                            <p><i class="fas fa-check-circle"></i> 
                                @if($sk->status == 'approved')
                                    <span class="text-success">Disetujui</span>
                                @elseif($sk->status == 'pending')
                                    <span class="text-warning">Menunggu</span>
                                @else
                                    <span class="text-danger">Ditolak</span>
                                @endif
                            </p>
                        </div>
                        @if($sk->file_path && $sk->status == 'approved')
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
                    <div class="document-card" style="grid-column: 1 / -1;">
                        <div class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            <h5>Belum Ada SK</h5>
                            <p>SK akan tersedia setelah disetujui oleh Kaprodi/Dekan.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
        
        // Search Jadwal
        document.getElementById('searchJadwal').addEventListener('input', function(e) {
            const search = e.target.value.toLowerCase();
            document.querySelectorAll('#jadwalTable tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(search) ? '' : 'none';
            });
        });
        
        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 992 && 
                !document.getElementById('sidebar').contains(e.target) && 
                !document.getElementById('sidebarToggle').contains(e.target)) {
                document.getElementById('sidebar').classList.remove('show');
            }
        });
    </script>
</body>
</html>