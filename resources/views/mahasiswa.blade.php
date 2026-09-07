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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-0">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap"></i>
                Student<span>Portal</span>
            </a>
            
            <div class="nav-profile">
                <div class="profile-info">
                    <div class="name">{{ $mahasiswa->nama ?? Auth::user()->name }}</div>
                    <div class="nim">NIM: {{ $mahasiswa->nim ?? '-' }}</div>
                    <div class="prodi">{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</div>
                </div>
                <a href="{{ route('mahasiswa.profile') }}" class="avatar text-decoration-none" title="Profil Saya">
                    {{ substr($mahasiswa->nama ?? Auth::user()->name ?? 'M', 0, 1) }}
                </a>
                <a href="{{ route('mahasiswa.profile') }}" class="btn btn-logout" style="border-color:#3498db;color:#2980b9;">
                    <i class="fas fa-user"></i> Profil Saya
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
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
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Welcome Section -->
        <div class="welcome-section">
            <h2>👋 Selamat Datang, {{ $mahasiswa->nama ?? 'Mahasiswa' }}!</h2>
            <p>Angkatan {{ $mahasiswa->angkatan ?? '-' }} - {{ $mahasiswa->prodi->nama_prodi ?? '-' }}</p>
        </div>

        <!-- Student Info Cards -->
        <div class="student-info-grid">
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="info-content">
                    <div class="label">NIM</div>
                    <div class="value">{{ $mahasiswa->nim ?? '-' }}</div>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="info-content">
                    <div class="label">Program Studi</div>
                    <div class="value">{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</div>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="info-content">
                    <div class="label">Angkatan</div>
                    <div class="value">{{ $mahasiswa->angkatan ?? '-' }}</div>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="info-content">
                    <div class="label">Pembimbing</div>
                    <div class="value">{{ count($pembimbing ?? []) }}/2</div>
                </div>
            </div>
        </div>

       <!-- SECTION 1: Pemilihan Dosen Pembimbing -->
        <h5 class="section-title">
            <i class="fas fa-user-graduate"></i>
            Pemilihan Dosen Pembimbing
        </h5>

        @php
            $jumlah = ($mahasiswa->pembimbing1 ? 1 : 0) + ($mahasiswa->pembimbing2 ? 1 : 0);
        @endphp

        <div class="full-width-card {{ $jumlah >= 2 ? 'completed' : '' }}">
            
            <!-- HEADER -->
            <div class="card-header-custom">
                <div class="card-icon {{ $jumlah >= 2 ? 'completed' : '' }}">
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
                    @if($jumlah >= 2)
                        <span class="status-badge status-completed">
                            <i class="fas fa-check-circle"></i> Selesai
                        </span>
                    @elseif($jumlah == 1)
                        <span class="status-badge status-pending">
                            <i class="fas fa-clock"></i> 1 dari 2 Dosen
                        </span>
                    @else
                        <span class="status-badge status-open">
                            <i class="fas fa-exclamation-circle"></i> Belum Memilih
                        </span>
                    @endif
                </div>
            </div>

            <!-- SELECTED LECTURERS -->
            <div class="lecturers-container">

                <!-- PEMBIMBING 1 -->
                <div class="lecturer-selected">
                    <i class="fas fa-user-check"></i>
                    <div class="info">
                        @if($mahasiswa->pembimbing1)
                            <div class="name">{{ $mahasiswa->pembimbing1->nama }}</div>
                        @else
                            <div class="name text-muted">Belum pilih pembimbing 1</div>
                        @endif
                        <div class="status">Pembimbing 1</div>
                    </div>
                </div>

                <!-- PEMBIMBING 2 -->
                <div class="lecturer-selected">
                    <i class="fas fa-user-check"></i>
                    <div class="info">
                        @if($mahasiswa->pembimbing2)
                            <div class="name">{{ $mahasiswa->pembimbing2->nama }}</div>
                        @else
                            <div class="name text-muted">Belum pilih pembimbing 2</div>
                        @endif
                        <div class="status">Pembimbing 2</div>
                    </div>
                </div>

            </div>

            <!-- BUTTON -->
            <div style="text-align: right;">
                <button class="btn btn-action btn-primary-custom" 
                        onclick="setJenisPembimbing()"
                        data-bs-toggle="modal" 
                        data-bs-target="#pilihDosenModal"
                        {{ $jumlah >= 2 ? 'disabled' : '' }}
                        style="width: auto; display: inline-flex; padding: 0.75rem 2rem;">
                    <i class="fas fa-user-plus"></i> 
                    {{ $jumlah >= 2 ? 'Dosen Lengkap' : 'Pilih Dosen' }}
                </button>
            </div>

        </div>
      
        <!-- SECTION 2: Pemilihan Dosen Pembimbing LKP -->
        <h5 class="section-title" style="margin-top: 2rem;">
            <i class="fas fa-briefcase"></i>
            Pemilihan Dosen Pembimbing LKP
        </h5>

        <div class="full-width-card {{ $mahasiswa->pembimbingLkp ? 'completed' : '' }}">
            
            <!-- HEADER -->
            <div class="card-header-custom">
                <div class="card-icon {{ $mahasiswa->pembimbingLkp ? 'completed' : '' }}" 
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
                    @if($mahasiswa->pembimbingLkp)
                        <span class="status-badge status-completed">
                            <i class="fas fa-check-circle"></i> Selesai
                        </span>
                    @else
                        <span class="status-badge status-open">
                            <i class="fas fa-exclamation-circle"></i> Belum Memilih
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- SELECTED LECTURER -->
            <div class="lecturers-container">
                <div class="lecturer-selected" 
                    style="{{ $mahasiswa->pembimbingLkp ? 'border-left-color: #3498db; background: #ebf5fb;' : 'background: #f8f9fa;' }}">
                    
                    <i class="fas {{ $mahasiswa->pembimbingLkp ? 'fa-user-check' : 'fa-user-plus' }}" 
                    style="color: {{ $mahasiswa->pembimbingLkp ? '#3498db' : '#adb5bd' }};"></i>

                    <div class="info">
                        @if($mahasiswa->pembimbingLkp)
                            <div class="name">{{ $mahasiswa->pembimbingLkp->nama }}</div>
                        @else
                            <div class="name" style="color: #adb5bd;">Belum dipilih</div>
                        @endif
                        <div class="status">Pembimbing LKP</div>
                    </div>
                </div>
            </div>
            
            <!-- BUTTON -->
            <div style="text-align: right;">
                <button class="btn btn-action btn-primary-custom" 
                        data-bs-toggle="modal" 
                        data-bs-target="#pilihDosenLkpModal"
                        {{ $mahasiswa->pembimbingLkp ? 'disabled' : '' }}
                        style="width: auto; display: inline-flex; padding: 0.75rem 2rem; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                    <i class="fas fa-user-plus"></i> 
                    {{ $mahasiswa->pembimbingLkp ? 'Dosen LKP Lengkap' : 'Pilih Dosen LKP' }}
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
                    <form action="{{ route('pilih.dosen.lkp') }}" method="POST">
                        @csrf

                        <div class="modal-body">
                            
                            <div class="row">
                                @foreach($dosens as $d)
                                    <div class="col-md-6 mb-3">
                                        <div class="card shadow-sm p-3" style="border-radius: 10px;">
                                            
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                    type="radio" 
                                                    name="dosen_id" 
                                                    value="{{ $d->id }}" 
                                                    id="dosen{{ $d->id }}"
                                                    required>

                                                <label class="form-check-label w-100" for="dosen{{ $d->id }}">
                                                    <strong>{{ $d->nama }}</strong><br>
                                                    <small class="text-muted">{{ $d->nidn ?? 'NIDN tidak tersedia' }}</small>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
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
            <div class="registration-card {{ $status['lkp'] ?? false ? 'completed' : '' }}">
                <div class="reg-card-icon {{ $status['lkp'] ?? false ? 'completed' : '' }}">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="reg-card-title">Seminar Kerja Praktik</div>
                <div class="reg-card-desc">
                    Presentasi laporan hasil kerja praktik/magang di industri
                </div>
                
                @if($status['lkp'] ?? false)
                    @if($lkp->tanggal_seminar ?? false)
                        <span class="status-badge status-completed mb-3">
                            <i class="fas fa-calendar-check"></i> Terjadwal
                        </span>
                    @else
                        <span class="status-badge status-pending mb-3">
                            <i class="fas fa-hourglass-half"></i> Menunggu Jadwal
                        </span>
                    @endif
                @else
                    <span class="status-badge status-open mb-3">
                        <i class="fas fa-clock"></i> Tersedia
                    </span>
                @endif
                
                <div class="requirements" style="margin: 0 0 1rem 0; padding: 0.75rem 1rem;">
                    <ul>
                        <li class="checked"><i class="fas fa-check-circle"></i> Laporan LKP</li>
                        <li class="checked"><i class="fas fa-check-circle"></i> Log Book</li>
                    </ul>
                </div>

                @if(($status['lkp'] ?? false) && ($lkp->tanggal_seminar ?? false))
                    <div class="alert alert-success py-2 px-3 mb-3" style="border-radius: 10px; font-size: 0.85rem;">
                        <i class="fas fa-calendar-day me-1"></i>
                        Jadwal Seminar: <strong>{{ \Carbon\Carbon::parse($lkp->tanggal_seminar)->translatedFormat('d M Y') }}</strong>
                    </div>
                @endif
                
                <button class="btn btn-action btn-primary-custom" 
                        data-bs-toggle="modal" 
                        data-bs-target="#daftarLKPModal"
                        {{ $status['lkp'] ?? false ? 'disabled' : '' }}>
                    <i class="fas fa-paper-plane"></i> 
                    {{ $status['lkp'] ?? false ? 'Sudah Daftar' : 'Daftar Sekarang' }}
                </button>
            </div>

            <!-- Card 2: Seminar Proposal -->
            <div class="registration-card {{ $status['proposal'] ?? false ? 'completed' : '' }}">
                <div class="reg-card-icon {{ $status['proposal'] ?? false ? 'completed' : '' }}">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="reg-card-title">Seminar Proposal</div>
                <div class="reg-card-desc">
                    Pengajuan judul dan proposal penelitian skripsi
                </div>
                
                @if($status['proposal'] ?? false)
                    @if($proposal->admin_verified ?? false)
                        <span class="status-badge status-completed mb-3">
                            <i class="fas fa-check-circle"></i> Diverifikasi
                        </span>
                    @else
                        <span class="status-badge status-pending mb-3">
                            <i class="fas fa-hourglass-half"></i> Menunggu Verifikasi
                        </span>
                    @endif
                @elseif(count($pembimbing ?? []) >= 2)
                    <span class="status-badge status-open mb-3">
                        <i class="fas fa-unlock"></i> Terbuka
                    </span>
                @else
                    <span class="status-badge status-closed mb-3">
                        <i class="fas fa-lock"></i> Terkunci
                    </span>
                @endif
                
                <div class="requirements" style="margin: 0 0 1rem 0; padding: 0.75rem 1rem;">
                    <ul>
                        <li class="{{ count($pembimbing ?? []) >= 2 ? 'checked' : '' }}">
                            <i class="fas fa-circle"></i> 2 Dosen Pembimbing
                        </li>
                        <li class="{{ $status['lkp'] ?? false ? 'checked' : '' }}">
                            <i class="fas fa-circle"></i> Lulus Seminar LKP
                        </li>
                    </ul>
                </div>

                @if(($status['proposal'] ?? false) && ($proposal->tanggal_seminar ?? false))
                    <div class="alert alert-success py-2 px-3 mb-3" style="border-radius: 10px; font-size: 0.85rem;">
                        <i class="fas fa-calendar-day me-1"></i>
                        Jadwal Seminar: <strong>{{ \Carbon\Carbon::parse($proposal->tanggal_seminar)->translatedFormat('d M Y') }}</strong>
                    </div>
                @endif
                
                <button class="btn btn-action btn-secondary-custom" 
                        data-bs-toggle="modal" 
                        data-bs-target="#daftarProposalModal"
                        {{ !(count($pembimbing ?? []) >= 2 && ($status['lkp'] ?? false)) ? 'disabled' : '' }}>
                    <i class="fas fa-paper-plane"></i> 
                    {{ $status['proposal'] ?? false ? 'Sudah Daftar' : 'Daftar Sekarang' }}
                </button>
            </div>

            <!-- Card 3: Sidang Skripsi -->
            <div class="registration-card {{ $status['sidang'] ?? false ? 'completed' : '' }}">
                <div class="reg-card-icon {{ $status['sidang'] ?? false ? 'completed' : '' }}">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="reg-card-title">Sidang Skripsi</div>
                <div class="reg-card-desc">
                    Ujian akhir program sebagai syarat kelulusan
                </div>
                
                @if($status['sidang'] ?? false)
                    @if($sidang->kaprodi_approved ?? false)
                        <span class="status-badge status-completed mb-3">
                            <i class="fas fa-check-circle"></i> Lulus
                        </span>
                    @elseif($sidang->admin_verified ?? false)
                        <span class="status-badge status-pending mb-3">
                            <i class="fas fa-hourglass-half"></i> Menunggu Persetujuan Kaprodi
                        </span>
                    @else
                        <span class="status-badge status-pending mb-3">
                            <i class="fas fa-hourglass-half"></i> Menunggu Verifikasi
                        </span>
                    @endif
                @elseif($status['proposal'] ?? false)
                    <span class="status-badge status-open mb-3">
                        <i class="fas fa-unlock"></i> Terbuka
                    </span>
                @else
                    <span class="status-badge status-closed mb-3">
                        <i class="fas fa-lock"></i> Terkunci
                    </span>
                @endif
                
                <div class="requirements" style="margin: 0 0 1rem 0; padding: 0.75rem 1rem;">
                    <ul>
                        <li class="{{ $status['proposal'] ?? false ? 'checked' : '' }}">
                            <i class="fas fa-circle"></i> Lulus Seminar Proposal
                        </li>
                        <li class="{{ $status['proposal'] ?? false ? 'checked' : '' }}">
                            <i class="fas fa-circle"></i> Skripsi Lengkap
                        </li>
                    </ul>
                </div>

                @if(($status['sidang'] ?? false) && ($sidang->tanggal_sidang ?? false))
                    <div class="alert alert-success py-2 px-3 mb-3" style="border-radius: 10px; font-size: 0.85rem;">
                        <i class="fas fa-calendar-day me-1"></i>
                        Jadwal Sidang: <strong>{{ \Carbon\Carbon::parse($sidang->tanggal_sidang)->translatedFormat('d M Y') }}</strong>
                    </div>
                @endif
                
                <button class="btn btn-action btn-primary-custom" 
                        data-bs-toggle="modal" 
                        data-bs-target="#daftarSidangModal"
                        {{ !($status['proposal'] ?? false) ? 'disabled' : '' }}>
                    <i class="fas fa-paper-plane"></i> 
                    {{ $status['sidang'] ?? false ? 'Sudah Daftar' : 'Daftar Sekarang' }}
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
                <form action="{{ route('dosen.pilih') }}" method="POST">
                    @csrf

                    <div class="modal-body">

                        <!-- INFO -->
                        <div class="alert alert-info">
                            Pilih dosen dari program studi 
                            <strong>{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</strong>
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
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">
                                        {{ $dosen->nama }} - {{ $dosen->nim_nuptk ?? '-' }}
                                    </option>
                                @endforeach
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

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Modal Body -->
            <div class="modal-body p-4" style="background: #f8f9fa;">
                <form action="{{ route('lkp.daftar') }}" method="POST" enctype="multipart/form-data" id="lkpForm">
                    @csrf
                    
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
                                        <input type="text" class="form-control bg-light" value="{{ $mahasiswa->nama }}" readonly style="border-radius: 0 10px 10px 0;">
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
                                        <input type="text" class="form-control bg-light" value="{{ $mahasiswa->nim }}" readonly style="border-radius: 0 10px 10px 0;">
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
                                        <input type="email" class="form-control bg-light" value="{{ Auth::user()->email }}" readonly style="border-radius: 0 10px 10px 0;">
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
                                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" required style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    @error('no_hp')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">
                                        <i class="fas fa-credit-card me-1"></i> NIK KTP <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-fingerprint text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control @error('nik_ktp') is-invalid @enderror" name="nik_ktp" value="{{ old('nik_ktp') }}" placeholder="16 digit NIK" required style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    @error('nik_ktp')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i> Tempat Lahir <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Kota" required style="border-radius: 10px;">
                                    @error('tempat_lahir')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small text-muted">
                                        <i class="fas fa-calendar me-1"></i> Tanggal Lahir <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required style="border-radius: 10px;">
                                    @error('tanggal_lahir')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
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
                                        <input type="text" class="form-control @error('judul_lkp') is-invalid @enderror" name="judul_lkp" value="{{ old('judul_lkp') }}" placeholder="Masukkan judul laporan kerja praktik" required style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    @error('judul_lkp')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
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
                                            value="{{ $mahasiswa->pembimbingLkp->nama ?? '-' }}" 
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
                                                @error('laporan_lkp')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
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
                                                @error('bukti_transfer')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
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
                    <form action="{{ route('proposal.daftar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->nim ?? '-' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->nama ?? '-' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul Skripsi</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}" required>
                            @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Proposal (PDF)</label>
                            <input type="file" class="form-control @error('proposal') is-invalid @enderror" name="proposal" accept=".pdf" required>
                            @error('proposal')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                    <h5 class="modal-title">📝 Pendaftaran Sidang Skripsi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sidang.daftar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->nim ?? '-' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->nama ?? '-' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dosen Pembimbing 1</label>
                            <input type="text" class="form-control" value="{{ $pembimbing[0]->nama ?? '-' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dosen Pembimbing 2</label>
                            <input type="text" class="form-control" value="{{ $pembimbing[1]->nama ?? '-' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Skripsi Lengkap (PDF)</label>
                            <input type="file" class="form-control @error('skripsi') is-invalid @enderror" name="skripsi" accept=".pdf" required>
                            @error('skripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Surat Bebas Pustaka</label>
                            <input type="file" class="form-control @error('bebas_pustaka') is-invalid @enderror" name="bebas_pustaka" accept=".pdf,.jpg,.png" required>
                            @error('bebas_pustaka')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
        <p>&copy; {{ date('Y') }} Student Portal - Sistem Informasi Akademik</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function setJenisPembimbing() {
        let jenisInput = document.getElementById('jenisInput');
        let infoText = document.getElementById('infoJenis');

        let pembimbing1 = @json($mahasiswa->pembimbing1_id);
        let pembimbing2 = @json($mahasiswa->pembimbing2_id);

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
        @if ($errors->any())
            @php
                $lkpFields = ['no_hp', 'nik_ktp', 'tempat_lahir', 'tanggal_lahir', 'judul_lkp', 'laporan_lkp', 'bukti_transfer'];
                $proposalFields = ['judul', 'proposal'];
                $sidangFields = ['skripsi', 'bebas_pustaka'];
                $errorKeys = collect($errors->keys());
            @endphp

            @if ($errorKeys->intersect($lkpFields)->isNotEmpty())
                new bootstrap.Modal(document.getElementById('daftarLKPModal')).show();
            @elseif ($errorKeys->intersect($proposalFields)->isNotEmpty())
                new bootstrap.Modal(document.getElementById('daftarProposalModal')).show();
            @elseif ($errorKeys->intersect($sidangFields)->isNotEmpty())
                new bootstrap.Modal(document.getElementById('daftarSidangModal')).show();
            @endif
        @endif
    });
    </script>

</body>
</html>