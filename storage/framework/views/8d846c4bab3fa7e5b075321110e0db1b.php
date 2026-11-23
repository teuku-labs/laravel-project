<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
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
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
        }
        
        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 1rem 2rem;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--dark-green) !important;
            font-size: 1.4rem;
        }
        
        .navbar-brand i { margin-right: 0.5rem; }
        
        .nav-profile {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .profile-info {
            text-align: right;
        }
        
        .profile-info .name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
        }
        
        .profile-info .nim {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        
        .profile-info .prodi {
            font-size: 0.75rem;
            color: var(--primary-green);
            font-weight: 500;
        }
        
        .avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .btn-logout {
            background: white;
            color: var(--dark-green);
            border: 2px solid var(--primary-green);
            border-radius: 10px;
            padding: 0.4rem 1.2rem;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            background: var(--primary-green);
            color: white;
        }
        
        /* Main Content */
        .main-content {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            border-radius: 20px;
            padding: 2rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(46, 204, 113, 0.25);
        }
        
        .welcome-section h2 {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .welcome-section p {
            opacity: 0.95;
            margin-bottom: 0;
        }
        
        /* Student Info Cards */
        .student-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .info-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
            border-left: 4px solid var(--primary-green);
        }
        
        .info-icon {
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
        
        .info-content .label {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 0.2rem;
        }
        
        .info-content .value {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--text-dark);
        }
        
        /* Section Title */
        .section-title {
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .section-title i {
            color: var(--primary-green);
        }
        
        /* Full Width Card (Dosen Selection) */
        .full-width-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border: 1px solid #eee;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .full-width-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--primary-green);
        }
        
        .full-width-card.completed::before {
            background: var(--dark-green);
        }
        
        .card-header-custom {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            background: var(--light-green);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-green);
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        
        .card-icon.completed {
            background: #d4edda;
            color: #28a745;
        }
        
        .card-title {
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--text-dark);
            margin-bottom: 0.3rem;
        }
        
        .card-subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        
        .status-open {
            background: rgba(46, 204, 113, 0.15);
            color: var(--dark-green);
        }
        
        .status-closed {
            background: rgba(173, 181, 189, 0.15);
            color: #6c757d;
        }
        
        .status-completed {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }
        
        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }
        
        /* Lecturer Selected Info */
        .lecturers-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }
        
        .lecturer-selected {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #d4edda;
            border-radius: 12px;
            border-left: 4px solid var(--dark-green);
        }
        
        .lecturer-selected i {
            color: var(--dark-green);
            font-size: 1.2rem;
        }
        
        .lecturer-selected .info {
            flex: 1;
        }
        
        .lecturer-selected .name {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-dark);
        }
        
        .lecturer-selected .status {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        
        /* Requirements */
        .requirements {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin: 1.5rem 0;
        }
        
        .requirements h6 {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.7rem;
            color: var(--text-dark);
        }
        
        .requirements ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.5rem;
        }
        
        .requirements li {
            font-size: 0.9rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .requirements li i {
            font-size: 0.6rem;
        }
        
        .requirements li.checked {
            color: var(--dark-green);
        }
        
        .requirements li.checked i {
            color: var(--primary-green);
            font-size: 0.8rem;
        }
        
        /* 3 Cards Grid for Registrations */
        .registration-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .registration-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border: 1px solid #eee;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .registration-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .registration-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--primary-green);
        }
        
        .registration-card.locked::before {
            background: #adb5bd;
        }
        
        .registration-card.completed::before {
            background: var(--dark-green);
        }
        
        .reg-card-icon {
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
        
        .reg-card-icon.locked {
            background: #f1f3f5;
            color: #adb5bd;
        }
        
        .reg-card-icon.completed {
            background: #d4edda;
            color: #28a745;
        }
        
        .reg-card-title {
            font-weight: 600;
            font-size: 1.05rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .reg-card-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
            flex: 1;
        }
        
        .btn-action {
            width: 100%;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            border: none;
            color: white;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.4);
            color: white;
        }
        
        .btn-secondary-custom {
            background: white;
            border: 2px solid #dee2e6;
            color: #6c757d;
        }
        
        .btn-secondary-custom:hover {
            border-color: var(--primary-green);
            color: var(--primary-green);
        }
        
        .btn-disabled {
            background: #f1f3f5;
            border: none;
            color: #adb5bd;
            cursor: not-allowed;
        }
        
        /* Alert Box */
        .alert-custom {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .alert-custom i {
            color: #ffc107;
            font-size: 1.3rem;
        }
        
        .alert-custom .content h6 {
            font-weight: 600;
            margin-bottom: 0.2rem;
        }
        
        .alert-custom .content p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 0;
        }
        
        /* Modal Styles */
        .modal-header {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            color: white;
        }
        
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
        
        /* Footer */
        footer {
            text-align: center;
            padding: 2rem;
            color: var(--text-muted);
            font-size: 0.9rem;
            border-top: 1px solid #eee;
            margin-top: 2rem;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .registration-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .navbar { padding: 1rem; }
            .main-content { padding: 1rem; }
            .registration-grid { grid-template-columns: 1fr; }
            .lecturers-container { grid-template-columns: 1fr; }
            .nav-profile { gap: 0.5rem; }
            .profile-info { display: none; }
            .student-info-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-0">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap"></i>
                Student<span>Portal</span>
            </a>
            
            <div class="nav-profile">
                <div class="profile-info">
                    <div class="name"><?php echo e($mahasiswa->nama ?? Auth::user()->name); ?></div>
                    <div class="nim">NIM: <?php echo e($mahasiswa->nim ?? '-'); ?></div>
                    <div class="prodi"><?php echo e($mahasiswa->prodi->nama_prodi ?? '-'); ?></div>
                </div>
                <a href="<?php echo e(route('mahasiswa.profile')); ?>" class="avatar text-decoration-none" title="Profil Saya">
                    <?php echo e(substr($mahasiswa->nama ?? Auth::user()->name ?? 'M', 0, 1)); ?>

                </a>
                <a href="<?php echo e(route('mahasiswa.profile')); ?>" class="btn btn-logout" style="border-color:#3498db;color:#2980b9;">
                    <i class="fas fa-user"></i> Profil Saya
                </a>
                <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Alert Notification -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Welcome Section -->
        <div class="welcome-section">
            <h2>👋 Selamat Datang, <?php echo e($mahasiswa->nama ?? 'Mahasiswa'); ?>!</h2>
            <p>Angkatan <?php echo e($mahasiswa->angkatan ?? '-'); ?> - <?php echo e($mahasiswa->prodi->nama_prodi ?? '-'); ?></p>
        </div>

        <!-- Student Info Cards -->
        <div class="student-info-grid">
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="info-content">
                    <div class="label">NIM</div>
                    <div class="value"><?php echo e($mahasiswa->nim ?? '-'); ?></div>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="info-content">
                    <div class="label">Program Studi</div>
                    <div class="value"><?php echo e($mahasiswa->prodi->nama_prodi ?? '-'); ?></div>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="info-content">
                    <div class="label">Angkatan</div>
                    <div class="value"><?php echo e($mahasiswa->angkatan ?? '-'); ?></div>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="info-content">
                    <div class="label">Pembimbing</div>
                    <div class="value"><?php echo e(count($pembimbing ?? [])); ?>/2</div>
                </div>
            </div>
        </div>

        <!-- SECTION 1: Pemilihan Dosen Pembimbing LKP -->
        <h5 class="section-title">
            <i class="fas fa-briefcase"></i>
            Pemilihan Dosen Pembimbing LKP / Akademik
        </h5>

        <div class="full-width-card <?php echo e($mahasiswa->pembimbingLkp ? 'completed' : ''); ?>">
            
            <!-- HEADER -->
            <div class="card-header-custom">
                <div class="card-icon <?php echo e($mahasiswa->pembimbingLkp ? 'completed' : ''); ?>" 
                    style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white;">
                    <i class="fas fa-industry"></i>
                </div>

                <div>
                    <div class="card-title">Pilih Dosen Pembimbing Kerja Praktik</div>
                    <div class="card-subtitle">
                        Pilih 1 dosen pembimbing untuk mendampingi selama kerja praktik
                    </div>
                </div>

                <!-- STATUS -->
                <div class="ms-auto">
                    <?php if($mahasiswa->pembimbingLkp): ?>
                        <span class="status-badge status-completed">
                            <i class="fas fa-check-circle"></i> Selesai
                        </span>
                    <?php else: ?>
                        <span class="status-badge status-open">
                            <i class="fas fa-exclamation-circle"></i> Belum Memilih
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- SELECTED LECTURER -->
            <div class="lecturers-container">
                <div class="lecturer-selected" 
                    style="<?php echo e($mahasiswa->pembimbingLkp ? 'border-left-color: #3498db; background: #ebf5fb;' : 'background: #f8f9fa;'); ?>">
                    
                    <i class="fas <?php echo e($mahasiswa->pembimbingLkp ? 'fa-user-check' : 'fa-user-plus'); ?>" 
                    style="color: <?php echo e($mahasiswa->pembimbingLkp ? '#3498db' : '#adb5bd'); ?>;"></i>

                    <div class="info">
                        <?php if($mahasiswa->pembimbingLkp): ?>
                            <div class="name"><?php echo e($mahasiswa->pembimbingLkp->nama); ?></div>
                        <?php else: ?>
                            <div class="name" style="color: #adb5bd;">Belum dipilih</div>
                        <?php endif; ?>
                        <div class="status">Pembimbing LKP</div>
                    </div>
                </div>
            </div>
            
            <!-- BUTTON -->
            <div style="text-align: right;">
                <button class="btn btn-action btn-primary-custom" 
                        data-bs-toggle="modal" 
                        data-bs-target="#pilihDosenLkpModal"
                        <?php echo e($mahasiswa->pembimbingLkp ? 'disabled' : ''); ?>

                        style="width: auto; display: inline-flex; padding: 0.75rem 2rem; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                    <i class="fas fa-user-plus"></i> 
                    <?php echo e($mahasiswa->pembimbingLkp ? 'Dosen LKP Lengkap' : 'Pilih Dosen LKP'); ?>

                </button>
            </div>

        </div>
       <!-- SECTION 2: Pemilihan Dosen Pembimbing -->
        <h5 class="section-title" style="margin-top: 2rem;">
            <i class="fas fa-user-graduate"></i>
            Pemilihan Dosen Pembimbing
        </h5>

        <?php
            $jumlah = ($mahasiswa->pembimbing1 ? 1 : 0) + ($mahasiswa->pembimbing2 ? 1 : 0);
        ?>

        <div class="full-width-card <?php echo e($jumlah >= 2 ? 'completed' : ''); ?>">
            
            <!-- HEADER -->
            <div class="card-header-custom">
                <div class="card-icon <?php echo e($jumlah >= 2 ? 'completed' : ''); ?>">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>

                <div>
                    <div class="card-title">Pilih Dosen Pembimbing Proposal/Skripsi</div>
                    <div class="card-subtitle">
                        Anda perlu memilih 2 dosen pembimbing dari program studi Anda
                    </div>
                </div>

                <!-- STATUS -->
                <div class="ms-auto">
                    <?php if($jumlah >= 2): ?>
                        <span class="status-badge status-completed">
                            <i class="fas fa-check-circle"></i> Selesai
                        </span>
                    <?php elseif($jumlah == 1): ?>
                        <span class="status-badge status-pending">
                            <i class="fas fa-clock"></i> 1 dari 2 Dosen
                        </span>
                    <?php else: ?>
                        <span class="status-badge status-open">
                            <i class="fas fa-exclamation-circle"></i> Belum Memilih
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- SELECTED LECTURERS -->
            <div class="lecturers-container">

                <!-- PEMBIMBING 1 -->
                <div class="lecturer-selected">
                    <i class="fas fa-user-check"></i>
                    <div class="info">
                        <?php if($mahasiswa->pembimbing1): ?>
                            <div class="name"><?php echo e($mahasiswa->pembimbing1->nama); ?></div>
                        <?php else: ?>
                            <div class="name text-muted">Belum pilih pembimbing 1</div>
                        <?php endif; ?>
                        <div class="status">Pembimbing 1</div>
                    </div>
                </div>

                <!-- PEMBIMBING 2 -->
                <div class="lecturer-selected">
                    <i class="fas fa-user-check"></i>
                    <div class="info">
                        <?php if($mahasiswa->pembimbing2): ?>
                            <div class="name"><?php echo e($mahasiswa->pembimbing2->nama); ?></div>
                        <?php else: ?>
                            <div class="name text-muted">Belum pilih pembimbing 2</div>
                        <?php endif; ?>
                        <div class="status">Pembimbing 2</div>
                    </div>
                </div>

            </div>

            <!-- STATUS PENGAJUAN PEMBIMBING -->
            <?php if(($pengajuanPending ?? collect())->isNotEmpty() || ($pengajuanRejected ?? collect())->isNotEmpty()): ?>
                <div class="mt-3">
                    <?php $__currentLoopData = $pengajuanPending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="alert alert-warning py-2 px-3 mb-2" style="border-radius: 10px; font-size: 0.85rem;">
                            <i class="fas fa-hourglass-half me-1"></i>
                            Menunggu persetujuan <strong><?php echo e($p->dosen->nama ?? '-'); ?></strong>
                            sebagai <?php echo e($p->catatan === 'pembimbing1' ? 'Pembimbing 1' : 'Pembimbing 2'); ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $pengajuanRejected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="alert alert-danger py-2 px-3 mb-2" style="border-radius: 10px; font-size: 0.85rem;">
                            <i class="fas fa-times-circle me-1"></i>
                            Pengajuan ke <strong><?php echo e($p->dosen->nama ?? '-'); ?></strong>
                            (<?php echo e($p->catatan === 'pembimbing1' ? 'Pembimbing 1' : 'Pembimbing 2'); ?>) ditolak.
                            Silakan ajukan ke dosen lain.
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <!-- BUTTON -->
            <div style="text-align: right;">
                <button class="btn btn-action btn-primary-custom" 
                        onclick="setJenisPembimbing()"
                        data-bs-toggle="modal" 
                        data-bs-target="#pilihDosenModal"
                        <?php echo e($jumlah >= 2 ? 'disabled' : ''); ?>

                        style="width: auto; display: inline-flex; padding: 0.75rem 2rem;">
                    <i class="fas fa-user-plus"></i> 
                    <?php echo e($jumlah >= 2 ? 'Dosen Lengkap' : 'Pilih Dosen'); ?>

                </button>
            </div>

        </div>
      
        <!-- MODAL: PILIH DOSEN LKP -->
        <div class="modal fade" id="pilihDosenLkpModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    
                    <!-- Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-user-tie"></i> Pilih Dosen Pembimbing LKP
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Form -->
                    <form action="<?php echo e(route('pilih.dosen.lkp')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="modal-body">
                            
                            <div class="row">
                                <?php $__currentLoopData = $dosens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card shadow-sm p-3" style="border-radius: 10px;">
                                            
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                    type="radio" 
                                                    name="dosen_id" 
                                                    value="<?php echo e($d->id); ?>" 
                                                    id="dosen<?php echo e($d->id); ?>"
                                                    required>

                                                <label class="form-check-label w-100" for="dosen<?php echo e($d->id); ?>">
                                                    <strong><?php echo e($d->nama); ?></strong><br>
                                                    <small class="text-muted"><?php echo e($d->nidn ?? 'NIDN tidak tersedia'); ?></small>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                        </div>

                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Simpan Pilihan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>


        <!-- SECTION 2: 3 Cards for Registrations -->
        <h5 class="section-title">
            <i class="fas fa-clipboard-list"></i>
            Pendaftaran Seminar & Sidang
        </h5>
        
        <div class="registration-grid">
            
            <!-- Card 1: Seminar Kerja Praktik -->
            <div class="registration-card <?php echo e($status['lkp'] ?? false ? 'completed' : ''); ?>">
                <div class="reg-card-icon <?php echo e($status['lkp'] ?? false ? 'completed' : ''); ?>">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="reg-card-title">Seminar Kerja Praktik</div>
                <div class="reg-card-desc">
                    Presentasi laporan hasil kerja praktik/magang di industri
                </div>
                
                <?php if($status['lkp'] ?? false): ?>
                    <?php if($lkp->tanggal_seminar ?? false): ?>
                        <span class="status-badge status-completed mb-3">
                            <i class="fas fa-calendar-check"></i> Terjadwal
                        </span>
                    <?php else: ?>
                        <span class="status-badge status-pending mb-3">
                            <i class="fas fa-hourglass-half"></i> Menunggu Jadwal
                        </span>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="status-badge status-open mb-3">
                        <i class="fas fa-clock"></i> Tersedia
                    </span>
                <?php endif; ?>
                
                <div class="requirements" style="margin: 0 0 1rem 0; padding: 0.75rem 1rem;">
                    <ul>
                        <li class="<?php echo e($status['lkp'] ?? false ? 'checked' : ''); ?>"><i class="fas <?php echo e($status['lkp'] ?? false ? 'fa-check-circle' : 'fa-circle'); ?>"></i> Berkas Laporan LKP (PDF)</li>
                        <li class="<?php echo e($status['lkp'] ?? false ? 'checked' : ''); ?>"><i class="fas <?php echo e($status['lkp'] ?? false ? 'fa-check-circle' : 'fa-circle'); ?>"></i> Bukti Transfer</li>
                    </ul>
                </div>

                <?php if(($status['lkp'] ?? false) && ($lkp->tanggal_seminar ?? false)): ?>
                    <div class="alert alert-success py-2 px-3 mb-3" style="border-radius: 10px; font-size: 0.85rem;">
                        <i class="fas fa-calendar-day me-1"></i>
                        Jadwal Seminar: <strong><?php echo e(\Carbon\Carbon::parse($lkp->tanggal_seminar)->translatedFormat('d M Y')); ?></strong>
                    </div>
                <?php endif; ?>
                
                <button class="btn btn-action btn-primary-custom" 
                        data-bs-toggle="modal" 
                        data-bs-target="#daftarLKPModal"
                        <?php echo e($status['lkp'] ?? false ? 'disabled' : ''); ?>>
                    <i class="fas fa-paper-plane"></i> 
                    <?php echo e($status['lkp'] ?? false ? 'Sudah Daftar' : 'Daftar Sekarang'); ?>

                </button>
            </div>

            <!-- Card 2: Seminar Proposal -->
            <div class="registration-card <?php echo e($status['proposal'] ?? false ? 'completed' : ''); ?>">
                <div class="reg-card-icon <?php echo e($status['proposal'] ?? false ? 'completed' : ''); ?>">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="reg-card-title">Seminar Proposal</div>
                <div class="reg-card-desc">
                    Pengajuan judul dan proposal penelitian skripsi
                </div>
                
                <?php if($status['proposal'] ?? false): ?>
                    <?php if($proposal->tanggal_seminar ?? false): ?>
                        <span class="status-badge status-completed mb-3">
                            <i class="fas fa-check-circle"></i> Terjadwal
                        </span>
                    <?php else: ?>
                        <span class="status-badge status-pending mb-3">
                            <i class="fas fa-hourglass-half"></i> Menunggu Jadwal Kaprodi
                        </span>
                    <?php endif; ?>
                <?php elseif(count($pembimbing ?? []) >= 2 && ($status['lkp_lulus'] ?? false)): ?>
                    <span class="status-badge status-open mb-3">
                        <i class="fas fa-unlock"></i> Terbuka
                    </span>
                <?php else: ?>
                    <span class="status-badge status-closed mb-3">
                        <i class="fas fa-lock"></i> Terkunci
                    </span>
                <?php endif; ?>
                
                <div class="requirements" style="margin: 0 0 1rem 0; padding: 0.75rem 1rem;">
                    <ul>
                        <li class="<?php echo e(count($pembimbing ?? []) >= 2 ? 'checked' : ''); ?>">
                            <i class="fas fa-circle"></i> 2 Dosen Pembimbing
                        </li>
                        <li class="<?php echo e($status['lkp_lulus'] ?? false ? 'checked' : ''); ?>">
                            <i class="fas fa-circle"></i> Lulus Seminar LKP (nilai sudah diinput &amp; minimal C)
                        </li>
                    </ul>
                </div>

                <?php if(($status['proposal'] ?? false) && ($proposal->tanggal_seminar ?? false)): ?>
                    <div class="alert alert-success py-2 px-3 mb-3" style="border-radius: 10px; font-size: 0.85rem;">
                        <i class="fas fa-calendar-day me-1"></i>
                        Jadwal Seminar: <strong><?php echo e(\Carbon\Carbon::parse($proposal->tanggal_seminar)->translatedFormat('d M Y')); ?></strong>
                    </div>
                <?php endif; ?>
                
                <button class="btn btn-action btn-secondary-custom" 
                        data-bs-toggle="modal" 
                        data-bs-target="#daftarProposalModal"
                        <?php echo e(($status['proposal'] ?? false) || !(count($pembimbing ?? []) >= 2 && ($status['lkp_lulus'] ?? false)) ? 'disabled' : ''); ?>>
                    <i class="fas fa-paper-plane"></i> 
                    <?php echo e($status['proposal'] ?? false ? 'Sudah Daftar' : 'Daftar Sekarang'); ?>

                </button>
            </div>

            <!-- Card 3: Sidang Skripsi -->
            <div class="registration-card <?php echo e($status['sidang'] ?? false ? 'completed' : ''); ?>">
                <div class="reg-card-icon <?php echo e($status['sidang'] ?? false ? 'completed' : ''); ?>">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="reg-card-title">Sidang Skripsi</div>
                <div class="reg-card-desc">
                    Ujian akhir program sebagai syarat kelulusan
                </div>
                
                <?php if($status['sidang'] ?? false): ?>
                    <?php if($sidang->kaprodi_rejected ?? false): ?>
                        <span class="status-badge status-closed mb-3">
                            <i class="fas fa-times-circle"></i> Ditolak Kaprodi
                        </span>
                    <?php elseif($sidang->kaprodi_approved ?? false): ?>
                        <span class="status-badge status-completed mb-3">
                            <i class="fas fa-check-circle"></i> Lulus
                        </span>
                    <?php else: ?>
                        <span class="status-badge status-pending mb-3">
                            <i class="fas fa-hourglass-half"></i> Menunggu Persetujuan Kaprodi
                        </span>
                    <?php endif; ?>
                <?php elseif($status['proposal_lulus'] ?? false): ?>
                    <span class="status-badge status-open mb-3">
                        <i class="fas fa-unlock"></i> Terbuka
                    </span>
                <?php elseif($status['proposal'] ?? false): ?>
                    <span class="status-badge status-pending mb-3">
                        <i class="fas fa-hourglass-half"></i> Menunggu Nilai Proposal
                    </span>
                <?php else: ?>
                    <span class="status-badge status-closed mb-3">
                        <i class="fas fa-lock"></i> Terkunci
                    </span>
                <?php endif; ?>
                
                <div class="requirements" style="margin: 0 0 1rem 0; padding: 0.75rem 1rem;">
                    <ul>
                        <li class="<?php echo e($status['proposal_lulus'] ?? false ? 'checked' : ''); ?>">
                            <i class="fas fa-circle"></i> Lulus Seminar Proposal (nilai akhir minimal C)
                        </li>
                        <li class="<?php echo e($status['sidang'] ?? false ? 'checked' : ''); ?>">
                            <i class="fas fa-circle"></i> Skripsi Lengkap
                        </li>
                    </ul>
                </div>

                <?php if(($status['sidang_ditolak'] ?? false)): ?>
                    <div class="alert alert-danger py-2 px-3 mb-3" style="border-radius: 10px; font-size: 0.85rem;">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        <strong>Ditolak Kaprodi.</strong>
                        <?php echo e($sidang->catatan_kaprodi ?: 'Tidak ada catatan.'); ?>

                        <br>Silakan perbaiki berkas lalu kirim ulang.
                    </div>
                <?php endif; ?>

                <?php if(($status['sidang'] ?? false) && ($sidang->tanggal_sidang ?? false)): ?>
                    <div class="alert alert-success py-2 px-3 mb-3" style="border-radius: 10px; font-size: 0.85rem;">
                        <i class="fas fa-calendar-day me-1"></i>
                        Jadwal Sidang: <strong><?php echo e(\Carbon\Carbon::parse($sidang->tanggal_sidang)->translatedFormat('d M Y')); ?></strong>
                    </div>
                <?php endif; ?>
                
                <button class="btn btn-action btn-primary-custom" 
                        data-bs-toggle="modal" 
                        data-bs-target="#daftarSidangModal"
                        <?php echo e((!($status['proposal_lulus'] ?? false) || (($status['sidang'] ?? false) && !($status['sidang_ditolak'] ?? false))) ? 'disabled' : ''); ?>>
                    <i class="fas fa-paper-plane"></i> 
                    <?php if($status['sidang_ditolak'] ?? false): ?>
                        Kirim Ulang Berkas
                    <?php elseif($status['sidang'] ?? false): ?>
                        Sudah Daftar
                    <?php else: ?>
                        Daftar Sekarang
                    <?php endif; ?>
                </button>
            </div>

        </div>

    </div>

    <!-- MODAL PILIH DOSEN PEMBIMBING -->
    <div class="modal fade" id="pilihDosenModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                
                <!-- HEADER -->
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        👨‍🏫 Pilih Dosen Pembimbing
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- FORM -->
                <form action="<?php echo e(route('dosen.pilih')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="modal-body">

                        <!-- INFO -->
                        <div class="alert alert-info">
                            Pilih dosen dari program studi 
                            <strong><?php echo e($mahasiswa->prodi->nama_prodi ?? '-'); ?></strong>
                        </div>

                        <!-- INFO JENIS -->
                        <div class="mb-3">
                            <p id="infoJenis" class="fw-bold text-primary"></p>
                        </div>

                        <!-- INPUT HIDDEN -->
                        <input type="hidden" name="jenis" id="jenisInput">

                        <!-- PILIH DOSEN -->
                        <div class="mb-3">
                            <label class="form-label">Pilih Dosen</label>
                            <select class="form-select" name="dosen_id" required>
                                <option value="">-- Pilih Dosen --</option>
                                <?php $__currentLoopData = $dosens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dosen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dosen->id); ?>">
                                        <?php echo e($dosen->nama); ?> - <?php echo e($dosen->nim_nuptk ?? '-'); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            ✔ Simpan Pilihan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="daftarLKPModal" tabindex="-1" aria-labelledby="daftarLKPModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            
            <!-- Pop up LKP -->
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-briefcase" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-0" id="daftarLKPModalLabel">
                            📄 Pendaftaran Seminar LKP
                        </h5>
                        <small class="text-white-50">Lengkapi data diri dan unggah dokumen persyaratan</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity: 1;"></button>
            </div>

            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <!-- Modal Body -->
            <div class="modal-body p-4" style="background: #f8f9fa;">
                <form action="<?php echo e(route('lkp.daftar')); ?>" method="POST" enctype="multipart/form-data" id="lkpForm">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Progress Steps -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center" style="position: relative;">
                            <div style="position: absolute; top: 20px; left: 0; right: 0; height: 3px; background: #e9ecef; z-index: 1;"></div>
                            
                            <div class="text-center" style="z-index: 2; background: #f8f9fa; padding: 0 10px;">
                                <div class="step-icon" style="width: 40px; height: 40px; background: #2ecc71; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 5px; color: white; font-weight: 600;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <small class="fw-semibold text-success">Data Diri</small>
                            </div>
                            
                            <div class="text-center" style="z-index: 2; background: #f8f9fa; padding: 0 10px;">
                                <div class="step-icon" style="width: 40px; height: 40px; background: #2ecc71; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 5px; color: white; font-weight: 600;">
                                    <i class="fas fa-book"></i>
                                </div>
                                <small class="fw-semibold text-success">Data LKP</small>
                            </div>
                            
                            <div class="text-center" style="z-index: 2; background: #f8f9fa; padding: 0 10px;">
                                <div class="step-icon" style="width: 40px; height: 40px; background: #2ecc71; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 5px; color: white; font-weight: 600;">
                                    <i class="fas fa-upload"></i>
                                </div>
                                <small class="fw-semibold text-success">Dokumen</small>
                            </div>
                        </div>
                    </div>

                    <!-- Section 1: Data Diri -->
                    <div class="card border-0 shadow-sm mb-3" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-header border-0" style="background: linear-gradient(135deg, #e8f8f0 0%, #d4edda 100%); padding: 1rem 1.5rem;">
                            <h6 class="mb-0 fw-bold" style="color: #27ae60;">
                                <i class="fas fa-user-circle me-2"></i>Informasi Pribadi
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">
                                        <i class="fas fa-user me-1"></i> Nama Mahasiswa
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control bg-light" value="<?php echo e($mahasiswa->nama); ?>" readonly style="border-radius: 0 10px 10px 0;">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">
                                        <i class="fas fa-id-card me-1"></i> NIM
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-barcode text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control bg-light" value="<?php echo e($mahasiswa->nim); ?>" readonly style="border-radius: 0 10px 10px 0;">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">
                                        <i class="fas fa-envelope me-1"></i> Email
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-at text-muted"></i>
                                        </span>
                                        <input type="email" class="form-control bg-light" value="<?php echo e(Auth::user()->email); ?>" readonly style="border-radius: 0 10px 10px 0;">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">
                                        <i class="fas fa-phone me-1"></i> Nomor HP <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-mobile-alt text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="no_hp" value="<?php echo e(old('no_hp')); ?>" placeholder="08xxxxxxxxxx" required style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">
                                        <i class="fas fa-credit-card me-1"></i> NIK KTP <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-fingerprint text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control <?php $__errorArgs = ['nik_ktp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="nik_ktp" value="<?php echo e(old('nik_ktp')); ?>" placeholder="16 digit NIK" inputmode="numeric" maxlength="16" pattern="[0-9]{16}" required style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    <?php $__errorArgs = ['nik_ktp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i> Tempat Lahir <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['tempat_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tempat_lahir" value="<?php echo e(old('tempat_lahir')); ?>" placeholder="Kota" required style="border-radius: 10px;">
                                    <?php $__errorArgs = ['tempat_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small text-muted">
                                        <i class="fas fa-calendar me-1"></i> Tanggal Lahir <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['tanggal_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tanggal_lahir" value="<?php echo e(old('tanggal_lahir')); ?>" required style="border-radius: 10px;">
                                    <?php $__errorArgs = ['tanggal_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Data LKP -->
                    <div class="card border-0 shadow-sm mb-3" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-header border-0" style="background: linear-gradient(135deg, #e8f8f0 0%, #d4edda 100%); padding: 1rem 1.5rem;">
                            <h6 class="mb-0 fw-bold" style="color: #27ae60;">
                                <i class="fas fa-briefcase me-2"></i>Informasi Kerja Praktik
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold small text-muted">
                                        <i class="fas fa-book-open me-1"></i> Judul LKP <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-pen-fancy text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control <?php $__errorArgs = ['judul_lkp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="judul_lkp" value="<?php echo e(old('judul_lkp')); ?>" placeholder="Masukkan judul laporan kerja praktik" required style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    <?php $__errorArgs = ['judul_lkp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-muted">
                                        <i class="fas fa-chalkboard-teacher me-1"></i> Dosen Pembimbing
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-user-tie text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control bg-light" 
                                            value="<?php echo e($mahasiswa->pembimbingLkp->nama ?? '-'); ?>" 
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Section 3: Upload Dokumen -->
                    <div class="card border-0 shadow-sm mb-3" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-header border-0" style="background: linear-gradient(135deg, #e8f8f0 0%, #d4edda 100%); padding: 1rem 1.5rem;">
                            <h6 class="mb-0 fw-bold" style="color: #27ae60;">
                                <i class="fas fa-file-upload me-2"></i>Unggah Dokumen
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Section Upload Dokumen -->
                                <div class="card border-0 shadow-sm mb-3" style="border-radius: 15px; overflow: hidden;">
                                    <div class="card-header border-0" style="background: linear-gradient(135deg, #e8f8f0 0%, #d4edda 100%); padding: 1rem 1.5rem;">
                                        <h6 class="mb-0 fw-bold" style="color: #27ae60;">
                                            <i class="fas fa-file-upload me-2"></i>Unggah Dokumen
                                        </h6>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-4">
                                            <!-- Upload Laporan LKP -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small text-muted mb-2">
                                                    <i class="fas fa-file-pdf me-1"></i> Laporan KP (PDF) <span class="text-danger">*</span>
                                                </label>
                                                <div class="upload-area" id="uploadLaporan">
                                                    <input type="file" class="form-control d-none" id="laporanLkp" name="laporan_lkp" accept=".pdf" required>
                                                    <div class="upload-box" id="boxLaporan" onclick="document.getElementById('laporanLkp').click()" 
                                                        style="border: 2px dashed #2ecc71; border-radius: 15px; padding: 2rem 1.5rem; text-align: center; background: linear-gradient(135deg, #f8f9fa 0%, #e8f8f0 100%); cursor: pointer; transition: all 0.3s ease;">
                                                        <div class="upload-content">
                                                            <i class="fas fa-cloud-upload-alt" style="font-size: 3rem; color: #2ecc71; margin-bottom: 1rem;"></i>
                                                            <h6 class="fw-bold mb-1" style="color: #27ae60;">Klik atau Drag & Drop</h6>
                                                            <p class="mb-2 small text-muted">Upload Laporan Kerja Praktik</p>
                                                            <span class="badge" style="background: #2ecc71; color: white;">PDF - Max 10MB</span>
                                                        </div>
                                                        <div class="file-preview d-none">
                                                            <i class="fas fa-file-pdf" style="font-size: 3rem; color: #e74c3c; margin-bottom: 1rem;"></i>
                                                            <h6 class="fw-bold mb-1" id="laporanFileName"></h6>
                                                            <p class="mb-2 small text-muted" id="laporanFileSize"></p>
                                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="event.stopPropagation(); removeFile('laporan')">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['laporan_lkp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <!-- Upload Bukti Transfer -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small text-muted mb-2">
                                                    <i class="fas fa-receipt me-1"></i> Bukti Pembayaran <span class="text-danger">*</span>
                                                </label>
                                                <div class="upload-area" id="uploadBukti">
                                                    <input type="file" class="form-control d-none" id="buktiTransfer" name="bukti_transfer" accept=".pdf,.jpg,.png" required>
                                                    <div class="upload-box" id="boxBukti" onclick="document.getElementById('buktiTransfer').click()" 
                                                        style="border: 2px dashed #2ecc71; border-radius: 15px; padding: 2rem 1.5rem; text-align: center; background: linear-gradient(135deg, #f8f9fa 0%, #e8f8f0 100%); cursor: pointer; transition: all 0.3s ease;">
                                                        <div class="upload-content">
                                                            <i class="fas fa-money-bill-wave" style="font-size: 3rem; color: #2ecc71; margin-bottom: 1rem;"></i>
                                                            <h6 class="fw-bold mb-1" style="color: #27ae60;">Klik atau Drag & Drop</h6>
                                                            <p class="mb-2 small text-muted">Upload Bukti Pembayaran</p>
                                                            <span class="badge" style="background: #2ecc71; color: white;">PDF, JPG, PNG - Max 5MB</span>
                                                        </div>
                                                        <div class="file-preview d-none">
                                                            <i class="fas fa-file-image" style="font-size: 3rem; color: #3498db; margin-bottom: 1rem;"></i>
                                                            <h6 class="fw-bold mb-1" id="buktiFileName"></h6>
                                                            <p class="mb-2 small text-muted" id="buktiFileSize"></p>
                                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="event.stopPropagation(); removeFile('bukti')">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['bukti_transfer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Box -->
                            <div class="alert alert-info border-0 mt-4" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-radius: 12px; border-left: 4px solid #2196f3;">
                                <div class="d-flex align-items-start gap-3">
                                    <i class="fas fa-info-circle" style="font-size: 1.5rem; color: #2196f3; margin-top: 2px;"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1" style="color: #1976d2;">📋 Format Penamaan File</h6>
                                        <p class="mb-0 small" style="color: #546e7a;">
                                            Nama file laporan harus mengikuti format:<br>
                                            <code style="background: white; padding: 8px 12px; border-radius: 6px; color: #d32f2f; font-weight: 600; display: inline-block; margin-top: 5px;">
                                                Nama_NIM_SeminarLKP_Prodi.pdf
                                            </code>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer border-0 p-4" style="background: white; border-radius: 0 0 15px 15px;">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" style="border-radius: 10px; border-width: 2px;">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn px-4" id="submitBtn" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); color: white; border: none; border-radius: 10px; font-weight: 600; padding: 12px 30px;">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    /* Modal Animation */
    .modal.fade .modal-dialog {
        transform: translateY(-50px) scale(0.9);
        transition: all 0.3s ease;
    }
    
    .modal.show .modal-dialog {
        transform: translateY(0) scale(1);
    }
    
    /* Form Control Focus */
    .form-control:focus, .form-select:focus {
        border-color: #2ecc71;
        box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.15);
    }
    
    /* Input Group Focus */
    .input-group:focus-within .input-group-text {
        background: #e8f8f0;
        border-color: #2ecc71;
    }
    
    .input-group:focus-within .form-control {
        border-color: #2ecc71;
    }
    
    /* Upload Box Styles */
    .upload-box {
        position: relative;
        overflow: hidden;
    }
    
    .upload-box:hover {
        border-color: #27ae60 !important;
        background: linear-gradient(135deg, #e8f8f0 0%, #d4edda 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.2);
    }
    
    .upload-box.drag-over {
        border-color: #27ae60 !important;
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
    }
    
    .upload-content, .file-preview {
        transition: all 0.3s ease;
    }
    
    .file-preview.d-none {
        display: none !important;
    }
    
    .upload-content.d-none {
        display: none !important;
    }
    
    /* Checkbox Custom */
    .form-check-input:checked {
        background-color: #2ecc71;
        border-color: #2ecc71;
    }
    
    /* Button Hover Effect */
    .btn[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.4);
    }
    
    /* Scrollbar */
    .modal-body::-webkit-scrollbar {
        width: 8px;
    }
    
    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .modal-body::-webkit-scrollbar-thumb {
        background: #2ecc71;
        border-radius: 10px;
    }
    
    /* Progress Step Icon Animation */
    .step-icon {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 10px;
        }
        
        .modal-header {
            padding: 1rem;
        }
        
        .modal-body {
            padding: 1rem !important;
        }
        
        .modal-footer {
            padding: 1rem !important;
            flex-direction: column;
            gap: 10px;
        }
        
        .modal-footer .btn {
            width: 100%;
        }

        .modal {
            z-index: 1055 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }

        .modal-backdrop.show {
            opacity: 0.5 !important;
        }
    }
</style>

<!-- JavaScript for Drag & Drop + File Preview -->
<script>
    // ============================================
    // PENTING: Prevent Default Browser Behavior
    // ============================================
    
    // Prevent default drag behaviors on ENTIRE document
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        document.body.addEventListener(eventName, preventDefaults, false);
        document.documentElement.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    // ============================================
    // File Upload Handling
    // ============================================
    
    function setupFileUpload(inputId, boxId, fileNameId, fileSizeId) {
        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);
        const uploadContent = box.querySelector('.upload-content');
        const filePreview = box.querySelector('.file-preview');
        
        // File Select via Click
        input.addEventListener('change', function(e) {
            handleFile(e.target.files[0], uploadContent, filePreview, fileNameId, fileSizeId);
        });
        
        // Drag & Drop Events
        box.addEventListener('dragenter', function(e) {
            preventDefaults(e);
            box.style.borderColor = '#27ae60';
            box.style.background = 'linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%)';
            box.style.transform = 'scale(1.02)';
        });
        
        box.addEventListener('dragover', function(e) {
            preventDefaults(e);
            box.style.borderColor = '#27ae60';
            box.style.background = 'linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%)';
        });
        
        box.addEventListener('dragleave', function(e) {
            preventDefaults(e);
            // Only reset if leaving the box entirely
            if (!box.contains(e.relatedTarget)) {
                box.style.borderColor = '#2ecc71';
                box.style.background = 'linear-gradient(135deg, #f8f9fa 0%, #e8f8f0 100%)';
                box.style.transform = 'scale(1)';
            }
        });
        
        box.addEventListener('drop', function(e) {
            preventDefaults(e);
            box.style.borderColor = '#2ecc71';
            box.style.background = 'linear-gradient(135deg, #f8f9fa 0%, #e8f8f0 100%)';
            box.style.transform = 'scale(1)';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                // Validate file type
                const validTypes = inputId === 'laporanLkp' ? ['application/pdf'] : ['application/pdf', 'image/jpeg', 'image/png'];
                const file = files[0];
                
                if (!validTypes.includes(file.type)) {
                    alert('⚠️ Format file tidak sesuai!');
                    return;
                }
                
                // Assign file to input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
                
                handleFile(file, uploadContent, filePreview, fileNameId, fileSizeId);
            }
        });
    }
    
    // Handle File
    function handleFile(file, uploadContent, filePreview, fileNameId, fileSizeId) {
        if (!file) return;
        
        // Validate file size
        const maxSize = fileNameId.includes('laporan') ? 10 * 1024 * 1024 : 5 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('⚠️ Ukuran file terlalu besar! Maksimal ' + (maxSize / 1024 / 1024) + 'MB');
            return;
        }
        
        // Show preview
        uploadContent.classList.add('d-none');
        filePreview.classList.remove('d-none');
        
        document.getElementById(fileNameId).textContent = file.name;
        document.getElementById(fileSizeId).textContent = formatFileSize(file.size);
    }
    
    // Remove File
    function removeFile(type) {
        event.stopPropagation();
        if (type === 'laporan') {
            document.getElementById('laporanLkp').value = '';
            document.querySelector('#uploadLaporan .upload-content').classList.remove('d-none');
            document.querySelector('#uploadLaporan .file-preview').classList.add('d-none');
        } else if (type === 'bukti') {
            document.getElementById('buktiTransfer').value = '';
            document.querySelector('#uploadBukti .upload-content').classList.remove('d-none');
            document.querySelector('#uploadBukti .file-preview').classList.add('d-none');
        }
    }
    
    // Format File Size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Form Submit Handler
    document.getElementById('lkpForm')?.addEventListener('submit', function(e) {
        const checkboxes = document.querySelectorAll('#check1, #check2, #check3, #check4');
        let allChecked = true;
        checkboxes.forEach(cb => {
            if (!cb.checked) allChecked = false;
        });
        
        if (!allChecked) {
            e.preventDefault();
            alert('⚠️ Harap centang semua persyaratan sebelum mengirim!');
            return false;
        }
        
        const laporanFile = document.getElementById('laporanLkp').files[0];
        const buktiFile = document.getElementById('buktiTransfer').files[0];
        
        if (!laporanFile || !buktiFile) {
            e.preventDefault();
            alert('⚠️ Harap upload semua dokumen yang diperlukan!');
            return false;
        }
        
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
        submitBtn.disabled = true;
    });
    
    // Initialize on DOM Load
    document.addEventListener('DOMContentLoaded', function() {
        setupFileUpload('laporanLkp', 'boxLaporan', 'laporanFileName', 'laporanFileSize');
        setupFileUpload('buktiTransfer', 'boxBukti', 'buktiFileName', 'buktiFileSize');
    });
    
</script>

    <!-- Modal Daftar Proposal -->
    <div class="modal fade" id="daftarProposalModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">📝 Pendaftaran Seminar Proposal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('proposal.daftar')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-control" value="<?php echo e($mahasiswa->nim ?? '-'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" value="<?php echo e($mahasiswa->nama ?? '-'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul Skripsi</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="judul" value="<?php echo e(old('judul')); ?>" required>
                            <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Proposal (PDF)</label>
                            <input type="file" class="form-control <?php $__errorArgs = ['proposal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="proposal" accept=".pdf" required>
                            <?php $__errorArgs = ['proposal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-paper-plane"></i> Submit Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Daftar Sidang -->
    <div class="modal fade" id="daftarSidangModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">📝 <?php echo e(($status['sidang_ditolak'] ?? false) ? 'Kirim Ulang Berkas Sidang Skripsi' : 'Pendaftaran Sidang Skripsi'); ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('sidang.daftar')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php if($status['sidang_ditolak'] ?? false): ?>
                            <div class="alert alert-danger" style="font-size: 0.9rem;">
                                <strong>Catatan Kaprodi:</strong> <?php echo e($sidang->catatan_kaprodi ?: 'Tidak ada catatan.'); ?><br>
                                Upload ulang kedua berkas setelah diperbaiki.
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-control" value="<?php echo e($mahasiswa->nim ?? '-'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" value="<?php echo e($mahasiswa->nama ?? '-'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dosen Pembimbing 1</label>
                            <input type="text" class="form-control" value="<?php echo e($mahasiswa->pembimbing1->nama ?? '-'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dosen Pembimbing 2</label>
                            <input type="text" class="form-control" value="<?php echo e($mahasiswa->pembimbing2->nama ?? '-'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Skripsi Lengkap (PDF)</label>
                            <input type="file" class="form-control <?php $__errorArgs = ['skripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="skripsi" accept=".pdf" required>
                            <?php $__errorArgs = ['skripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Foto Pengesahan untuk Sidang Skripsi</label>
                            <input type="file" class="form-control <?php $__errorArgs = ['bebas_pustaka'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="bebas_pustaka" accept=".jpg,.jpeg,.png,.pdf" required>
                            <?php $__errorArgs = ['bebas_pustaka'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-paper-plane"></i> Submit Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo e(date('Y')); ?> Student Portal - Sistem Informasi Akademik</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function setJenisPembimbing() {
        let jenisInput = document.getElementById('jenisInput');
        let infoText = document.getElementById('infoJenis');

        let pembimbing1 = <?php echo json_encode($mahasiswa->pembimbing1_id, 15, 512) ?>;
        let pembimbing2 = <?php echo json_encode($mahasiswa->pembimbing2_id, 15, 512) ?>;

        if (!pembimbing1) {
            jenisInput.value = 'pembimbing1';
            infoText.innerText = 'Anda sedang memilih Pembimbing 1';
        } else if (!pembimbing2) {
            jenisInput.value = 'pembimbing2';
            infoText.innerText = 'Anda sedang memilih Pembimbing 2';
        }
    }

    // ✅ Buka kembali modal terkait secara otomatis kalau submit sebelumnya
    // gagal validasi, supaya mahasiswa langsung melihat pesan errornya.
    document.addEventListener('DOMContentLoaded', function () {
        <?php if($errors->any()): ?>
            <?php
                $lkpFields = ['no_hp', 'nik_ktp', 'tempat_lahir', 'tanggal_lahir', 'judul_lkp', 'laporan_lkp', 'bukti_transfer'];
                $proposalFields = ['judul', 'proposal'];
                $sidangFields = ['skripsi', 'bebas_pustaka'];
                $errorKeys = collect($errors->keys());
            ?>

            <?php if($errorKeys->intersect($lkpFields)->isNotEmpty()): ?>
                new bootstrap.Modal(document.getElementById('daftarLKPModal')).show();
            <?php elseif($errorKeys->intersect($proposalFields)->isNotEmpty()): ?>
                new bootstrap.Modal(document.getElementById('daftarProposalModal')).show();
            <?php elseif($errorKeys->intersect($sidangFields)->isNotEmpty()): ?>
                new bootstrap.Modal(document.getElementById('daftarSidangModal')).show();
            <?php endif; ?>
        <?php endif; ?>
    });
    </script>

</body>
</html><?php /**PATH C:\laragon\www\seminar-apk\resources\views/mahasiswa.blade.php ENDPATH**/ ?>