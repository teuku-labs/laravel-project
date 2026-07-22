<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
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
            overflow-x: hidden;
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
            transition: all 0.3s ease;
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
        
        .sidebar-brand i {
            font-size: 1.5rem;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
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
        
        .menu-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: white;
        }
        
        .menu-item.active {
            background: rgba(255,255,255,0.2);
            color: white;
            border-left-color: white;
        }
        
        .menu-item i {
            width: 25px;
            font-size: 1rem;
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
        
        .menu-item.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .menu-item.disabled:hover {
            background: none;
            border-left-color: transparent;
        }
        
        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        
        /* Top Navbar */
        .top-navbar {
            background: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            transition: color 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            color: var(--primary-green);
        }
        
        .breadcrumb-custom {
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        
        .breadcrumb-custom .active {
            color: var(--primary-green);
            font-weight: 500;
        }
        
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .notification-icon {
            position: relative;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }
        
        .notification-icon:hover {
            color: var(--primary-green);
        }
        
        .notification-icon .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e74c3c;
            color: white;
            font-size: 0.65rem;
            padding: 0.2rem 0.4rem;
            border-radius: 50%;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
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
            font-size: 0.9rem;
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
        
        /* Main Content Area */
        .content-area {
            padding: 2rem;
        }
        
        /* Permission Info Box */
        .permission-info {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            border-left: 4px solid #f39c12;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .permission-info h5 {
            color: #d35400;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .permission-info ul {
            margin: 0;
            padding-left: 1.5rem;
            color: #6c757d;
        }
        
        .permission-info li {
            margin-bottom: 0.3rem;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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
        .stat-card.danger { border-left-color: #e74c3c; }
        .stat-card.info { border-left-color: #3498db; }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            background: var(--light-green);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-green);
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        
        .stat-card.warning .stat-icon { background: #fef5e7; color: #f39c12; }
        .stat-card.danger .stat-icon { background: #fdedec; color: #e74c3c; }
        .stat-card.info .stat-icon { background: #ebf5fb; color: #3498db; }
        
        .stat-content .label {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
        }
        
        .stat-content .value {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-dark);
        }
        
        .stat-content .change {
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .stat-content .change.positive { color: var(--primary-green); }
        .stat-content .change.negative { color: #e74c3c; }
        
        /* Table Card */
        .table-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        
        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        
        .table-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .table-title i {
            color: var(--primary-green);
        }
        
        .btn-view-all {
            background: none;
            border: none;
            color: var(--primary-green);
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .btn-view-all:hover {
            color: var(--dark-green);
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
            border: none;
        }
        
        .custom-table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            font-size: 0.9rem;
            color: var(--text-dark);
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
        
        .status-pending {
            background: rgba(243, 156, 18, 0.15);
            color: #f39c12;
        }
        
        .status-approved {
            background: rgba(46, 204, 113, 0.15);
            color: var(--dark-green);
        }
        
        .status-rejected {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }
        
        .status-editing {
            background: rgba(52, 152, 219, 0.15);
            color: #3498db;
        }
        
        .action-btn {
            background: none;
            border: none;
            padding: 0.4rem 0.6rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 0.25rem;
        }
        
        .action-btn.view {
            background: rgba(52, 152, 219, 0.15);
            color: #3498db;
        }
        
        .action-btn.edit {
            background: rgba(243, 156, 18, 0.15);
            color: #f39c12;
        }
        
        .action-btn.approve {
            background: rgba(46, 204, 113, 0.15);
            color: var(--dark-green);
        }
        
        .action-btn.delete {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }
        
        .action-btn:hover {
            transform: scale(1.1);
        }
        
        .action-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }
        
        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .quick-action-btn {
            background: white;
            border: 2px solid #eee;
            border-radius: 12px;
            padding: 1.25rem;
            text-align: center;
            text-decoration: none;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }
        
        .quick-action-btn:hover {
            border-color: var(--primary-green);
            background: var(--light-green);
            transform: translateY(-3px);
        }
        
        .quick-action-btn i {
            font-size: 1.5rem;
            color: var(--primary-green);
            margin-bottom: 0.5rem;
        }
        
        .quick-action-btn span {
            display: block;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        /* Workflow Info */
        .workflow-box {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        
        .workflow-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-top: 2rem;
        }
        
        .workflow-steps::before {
            content: '';
            position: absolute;
            top: 25px;
            left: 0;
            right: 0;
            height: 3px;
            background: #e9ecef;
            z-index: 1;
        }
        
        .workflow-step {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
        }
        
        .workflow-circle {
            width: 50px;
            height: 50px;
            background: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-weight: 600;
            color: var(--text-muted);
        }
        
        .workflow-circle.active {
            background: var(--primary-green);
            color: white;
        }
        
        .workflow-circle.completed {
            background: var(--dark-green);
            color: white;
        }
        
        .workflow-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        
        /* Sidebar Collapsed State */
        .sidebar.collapsed {
            width: 80px;
        }
        
        .sidebar.collapsed .sidebar-brand span,
        .sidebar.collapsed .menu-category,
        .sidebar.collapsed .menu-item span,
        .sidebar.collapsed .menu-item .badge {
            display: none;
        }
        
        .sidebar.collapsed .menu-item {
            justify-content: center;
            padding: 0.85rem;
        }
        
        .sidebar.collapsed .menu-item i {
            margin-right: 0;
        }
        
        .main-wrapper.collapsed {
            margin-left: 80px;
        }
        
        /* Dropdown Menu */
        .dropdown-menu-custom {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            padding: 0.5rem 0;
            min-width: 200px;
            display: none;
            z-index: 1000;
        }
        
        .dropdown-menu-custom.show {
            display: block;
        }
        
        .dropdown-menu-custom a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .dropdown-menu-custom a:hover {
            background: var(--light-green);
            color: var(--dark-green);
        }
        
        .dropdown-menu-custom .divider {
            height: 1px;
            background: #eee;
            margin: 0.5rem 0;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-wrapper {
                margin-left: 0;
            }
            
            .main-wrapper.collapsed {
                margin-left: 0;
            }
        }
        
        @media (max-width: 768px) {
            .content-area {
                padding: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .top-navbar {
                padding: 1rem;
            }
            
            .user-info {
                display: none;
            }
            
            .workflow-steps {
                flex-wrap: wrap;
                gap: 1rem;
            }
            
            .workflow-steps::before {
                display: none;
            }
        }
        
        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .table-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                <i class="fas fa-shield-alt"></i>
                <span>Admin Portal</span>
            </a>
        </div>
        
        <nav class="sidebar-menu">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            
            <!-- Manajemen SDM Section -->
            <div class="menu-category">Manajemen SDM</div>
            
            <a href="{{ route('admin.dosen.index') }}" class="menu-item {{ request()->routeIs('admin.dosen.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Kelola Dosen</span>
                @if($pendingDosen ?? 0 > 0)
                    <span class="badge">{{ $pendingDosen }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.kaprodi.index') }}" class="menu-item {{ request()->routeIs('admin.kaprodi.*') ? 'active' : '' }}">
                <i class="fas fa-user-tie"></i>
                <span>Kelola Kaprodi</span>
            </a>
            
            <a href="{{ route('admin.dekan.index') }}" class="menu-item {{ request()->routeIs('admin.dekan.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i>
                <span>Kelola Dekan</span>
            </a>
            
            <!-- Note: Mahasiswa NOT managed by admin -->
            <a href="#" class="menu-item disabled" title="Mahasiswa mendaftar sendiri">
                <i class="fas fa-user-graduate"></i>
                <span>Mahasiswa</span>
                <span class="badge" style="background: #e74c3c;">Register Sendiri</span>
            </a>
            
            <!-- Akademik Section -->
            <div class="menu-category">Akademik</div>
            
            <a href="{{ route('admin.sk-pembimbing.index') }}" class="menu-item {{ request()->routeIs('admin.sk-pembimbing.*') ? 'active' : '' }}">
                <i class="fas fa-file-signature"></i>
                <span>SK Pembimbing</span>
                @if($pendingSK ?? 0 > 0)
                    <span class="badge">{{ $pendingSK }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.seminar.index') }}" class="menu-item {{ request()->routeIs('admin.seminar.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard"></i>
                <span>Pengajuan Seminar</span>
                @if($pendingSeminar ?? 0 > 0)
                    <span class="badge">{{ $pendingSeminar }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.sidang.index') }}" class="menu-item {{ request()->routeIs('admin.sidang.*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i>
                <span>Pengajuan Sidang</span>
                @if($pendingSidang ?? 0 > 0)
                    <span class="badge">{{ $pendingSidang }}</span>
                @endif
            </a>
            
            <!-- Approval Section (For Kaprodi/Dekan) -->
            <div class="menu-category" style="margin-top: 2rem;">Persetujuan</div>
            
            <a href="{{ route('admin.approval.index') }}" class="menu-item {{ request()->routeIs('admin.approval.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check"></i>
                <span>Perlu Persetujuan</span>
                @if($totalPendingApproval ?? 0 > 0)
                    <span class="badge" style="background: #e74c3c;">{{ $totalPendingApproval }}</span>
                @endif
            </a>
            
            <!-- Logout -->
            <div class="menu-category" style="margin-top: 2rem;">Lainnya</div>
            
            <a href="{{ route('admin.settings') }}" class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
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
                <div class="breadcrumb-custom">
                    <span>Admin</span> / <span class="active">Dashboard</span>
                </div>
            </div>
            
            <div class="navbar-right">
                <!-- Notifications -->
                <div class="notification-icon" data-bs-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                    <span class="badge">{{ ($pendingSK ?? 0) + ($pendingSeminar ?? 0) + ($pendingSidang ?? 0) }}</span>
                </div>
                
                <!-- User Profile -->
                <div class="user-profile" data-bs-toggle="dropdown">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->username ?? 'A', 0, 1) }}
                    </div>
                    <div class="user-info">
                        <div class="name">{{ Auth::user()->username ?? 'Admin' }}</div>
                        <div class="role">Administrator</div>
                    </div>
                </div>
                
                <!-- Profile Dropdown -->
                <div class="dropdown-menu-custom" id="profileDropdown">
                    <a href="{{ route('admin.profile') }}">
                        <i class="fas fa-user"></i>
                        <span>Profil Saya</span>
                    </a>
                    <a href="{{ route('admin.settings') }}">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                    <div class="divider"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 0.75rem 1rem; display: flex; align-items: center; gap: 0.75rem; color: #e74c3c;">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const mainWrapper = document.getElementById('mainWrapper');
        
        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth > 992) {
                sidebar.classList.toggle('collapsed');
                mainWrapper.classList.toggle('collapsed');
            } else {
                sidebar.classList.toggle('show');
            }
        });
        
        // Profile Dropdown
        const userProfile = document.querySelector('.user-profile');
        const profileDropdown = document.getElementById('profileDropdown');
        
        userProfile.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });
        
        document.addEventListener('click', function(e) {
            if (!profileDropdown.contains(e.target) && !userProfile.contains(e.target)) {
                profileDropdown.classList.remove('show');
            }
        });
        
        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 992 && 
                !sidebar.contains(e.target) && 
                !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>
</html>