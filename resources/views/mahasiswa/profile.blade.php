<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Student Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

        .btn-back {
            background: white;
            color: var(--dark-green);
            border: 2px solid var(--primary-green);
            border-radius: 10px;
            padding: 0.4rem 1.2rem;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: var(--primary-green);
            color: white;
        }

        .main-content {
            padding: 2rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0 auto 1.25rem;
        }

        .profile-name {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .profile-role {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .info-row {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
            gap: 1rem;
        }

        .info-row:last-child { border-bottom: none; }

        .info-icon {
            width: 42px;
            height: 42px;
            background: var(--light-green);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-green);
            flex-shrink: 0;
        }

        .info-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 0.1rem;
        }

        .info-value { font-weight: 500; font-size: 0.95rem; }

        .section-title {
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i { color: var(--primary-green); }

        .btn-save {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.65rem 1.75rem;
            font-weight: 600;
        }

        .btn-save:hover { color: white; opacity: 0.92; }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.15);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="{{ route('mahasiswa.dashboard') }}">
                <i class="fas fa-graduation-cap"></i>Student<span>Portal</span>
            </a>
            <a href="{{ route('mahasiswa.dashboard') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <div class="main-content">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Profile Info -->
        <div class="profile-card">
            <div class="profile-avatar">{{ substr($mahasiswa->nama ?? 'M', 0, 1) }}</div>
            <div class="profile-name">{{ $mahasiswa->nama ?? '-' }}</div>
            <div class="profile-role"><i class="fas fa-user-graduate"></i> Mahasiswa</div>

            <div class="info-row">
                <div class="info-icon"><i class="fas fa-id-card"></i></div>
                <div>
                    <div class="info-label">NIM</div>
                    <div class="info-value">{{ $mahasiswa->nim ?? '-' }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-envelope"></i></div>
                <div>
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $user->email ?? '-' }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-building"></i></div>
                <div>
                    <div class="info-label">Program Studi</div>
                    <div class="info-value">{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-calendar"></i></div>
                <div>
                    <div class="info-label">Angkatan</div>
                    <div class="info-value">{{ $mahasiswa->angkatan ?? '-' }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-user-tie"></i></div>
                <div>
                    <div class="info-label">Pembimbing 1</div>
                    <div class="info-value">{{ $mahasiswa->pembimbing1->nama ?? 'Belum dipilih' }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-user-tie"></i></div>
                <div>
                    <div class="info-label">Pembimbing 2</div>
                    <div class="info-value">{{ $mahasiswa->pembimbing2->nama ?? 'Belum dipilih' }}</div>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="profile-card">
            <h5 class="section-title"><i class="fas fa-lock"></i> Ganti Password</h5>

            <form action="{{ route('mahasiswa.settings.password') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">Password Lama</label>
                    <input type="password" name="current_password"
                           class="form-control @error('current_password') is-invalid @enderror">
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">Password Baru</label>
                    <input type="password" name="new_password"
                           class="form-control @error('new_password') is-invalid @enderror">
                    @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save"></i> Simpan Password
                </button>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>