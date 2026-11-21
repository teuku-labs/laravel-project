<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Pembimbing Saya - Student Portal</title>

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
    
        /* ---- SK Pembimbing ---- */
        .btn-download{background:linear-gradient(135deg,var(--primary-green),var(--dark-green));color:#fff;border:none;padding:.8rem 2rem;border-radius:12px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:.6rem;}
        .btn-download:hover{color:#fff;opacity:.92;}
        .btn-download.disabled{background:#c9ced3;pointer-events:none;cursor:not-allowed;}
        .steps{display:flex;flex-direction:column;gap:1rem;margin-top:.5rem;}
        .step{display:flex;gap:1rem;align-items:flex-start;}
        .step-dot{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:#e9ecef;color:#adb5bd;}
        .step.done .step-dot{background:rgba(40,167,69,.15);color:#28a745;}
        .step.current .step-dot{background:rgba(255,193,7,.18);color:#e0a800;}
        .step.rejected .step-dot{background:rgba(231,76,60,.15);color:#e74c3c;}
        .step-title{font-weight:600;font-size:.95rem;}
        .step-desc{font-size:.82rem;color:var(--text-muted);}
        .warn-text{color:#e67e22;font-size:.85rem;}
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="<?php echo e(route('mahasiswa.dashboard')); ?>">
                <i class="fas fa-graduation-cap"></i>Student<span>Portal</span>
            </a>
            <a href="<?php echo e(route('mahasiswa.dashboard')); ?>" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <div class="main-content">

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

        <?php
            $terbit    = $sk->sudahTerbit();
            $disetujui = (bool) $sk->kaprodi_approved;
            $ditolak   = (bool) $sk->kaprodi_rejected;
            $judul     = $sk->judulTga();
            $ttl       = $sk->tempatTanggalLahir();
            $kurang    = $sk->kekuranganData();
            $bisaUnduh = $terbit && $disetujui && empty($kurang);
        ?>

        <!-- Status pengajuan -->
        <div class="profile-card">
            <div class="section-title"><i class="fas fa-route"></i> Status Pengajuan SK Pembimbing</div>

            <div class="steps">
                <div class="step done">
                    <div class="step-dot"><i class="fas fa-paper-plane"></i></div>
                    <div>
                        <div class="step-title">Pengajuan dikirim</div>
                        <div class="step-desc"><?php echo e($sk->created_at->format('d-m-Y')); ?></div>
                    </div>
                </div>

                <div class="step <?php echo e($disetujui ? 'done' : ($ditolak ? 'rejected' : 'current')); ?>">
                    <div class="step-dot">
                        <i class="fas <?php echo e($disetujui ? 'fa-check' : ($ditolak ? 'fa-times' : 'fa-hourglass-half')); ?>"></i>
                    </div>
                    <div>
                        <div class="step-title">Persetujuan Kaprodi</div>
                        <div class="step-desc">
                            <?php if($disetujui): ?> Disetujui
                            <?php elseif($ditolak): ?> Ditolak. <?php echo e($sk->catatan_kaprodi ? 'Catatan: ' . $sk->catatan_kaprodi : ''); ?>

                            <?php else: ?> Menunggu persetujuan kaprodi
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="step <?php echo e($terbit ? 'done' : ($disetujui ? 'current' : '')); ?>">
                    <div class="step-dot"><i class="fas <?php echo e($terbit ? 'fa-check' : 'fa-stamp'); ?>"></i></div>
                    <div>
                        <div class="step-title">SK diterbitkan Dekan</div>
                        <div class="step-desc">
                            <?php if($terbit): ?> Terbit pada <?php echo e(\App\Models\PengajuanSk::tanggalIndonesia($sk->tanggal_sk)); ?>

                            <?php elseif($disetujui): ?> Menunggu dekan memberi nomor dan tanggal SK
                            <?php else: ?> Belum diproses
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Isi SK -->
        <div class="profile-card">
            <div class="section-title"><i class="fas fa-file-signature"></i> Isi SK</div>

            <div class="info-row">
                <div class="info-icon"><i class="fas fa-hashtag"></i></div>
                <div>
                    <div class="info-label">Nomor SK</div>
                    <div class="info-value"><?php echo e($terbit ? $sk->nomor_sk : 'Belum terbit'); ?></div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-calendar-day"></i></div>
                <div>
                    <div class="info-label">Tanggal SK</div>
                    <div class="info-value"><?php echo e($terbit ? \App\Models\PengajuanSk::tanggalIndonesia($sk->tanggal_sk) : 'Belum terbit'); ?></div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-calendar"></i></div>
                <div>
                    <div class="info-label">TA. Semester</div>
                    <div class="info-value"><?php echo e($sk->taSemester()); ?></div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-user-graduate"></i></div>
                <div>
                    <div class="info-label">Nama / NIM</div>
                    <div class="info-value"><?php echo e($mahasiswa->nama); ?> / <?php echo e($mahasiswa->nim); ?></div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-building"></i></div>
                <div>
                    <div class="info-label">Program Studi</div>
                    <div class="info-value"><?php echo e($mahasiswa->prodi->nama_prodi ?? '-'); ?></div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-birthday-cake"></i></div>
                <div>
                    <div class="info-label">Tempat/Tgl. Lahir</div>
                    <div class="info-value">
                        <?php if($ttl): ?> <?php echo e($ttl); ?>

                        <?php else: ?> <span class="warn-text"><i class="fas fa-exclamation-triangle"></i> Belum ada, daftar Seminar LKP terlebih dahulu</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-book"></i></div>
                <div>
                    <div class="info-label">Judul TGA</div>
                    <div class="info-value">
                        <?php if($judul): ?> <?php echo e($judul); ?>

                        <?php else: ?> <span class="warn-text"><i class="fas fa-exclamation-triangle"></i> Belum ada, daftar Proposal terlebih dahulu</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-user-tie"></i></div>
                <div>
                    <div class="info-label">Pembimbing Utama</div>
                    <div class="info-value"><?php echo e($sk->pembimbing1->nama ?? '-'); ?></div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-user-tie"></i></div>
                <div>
                    <div class="info-label">Pembimbing Pendamping</div>
                    <div class="info-value"><?php echo e($sk->pembimbing2->nama ?? '-'); ?></div>
                </div>
            </div>
        </div>

        <!-- Unduh -->
        <div class="profile-card" style="text-align:center;">
            <?php if($bisaUnduh): ?>
                <a href="<?php echo e(route('sk.unduh')); ?>" class="btn-download"><i class="fas fa-file-word"></i> Unduh SK (Word)</a>
                <div class="step-desc mt-2">File berformat .docx lengkap dengan kop surat, tanda tangan, dan stempel.</div>
            <?php else: ?>
                <span class="btn-download disabled"><i class="fas fa-file-word"></i> Unduh SK (Word)</span>
                <div class="step-desc mt-2">
                    <?php if(!$terbit): ?> SK dapat diunduh setelah diterbitkan oleh dekan.
                    <?php else: ?> SK belum bisa diunduh, data belum lengkap: <?php echo e(implode(', ', $kurang)); ?>.
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\laragon\www\seminar-apk\resources\views/mahasiswa/sk.blade.php ENDPATH**/ ?>