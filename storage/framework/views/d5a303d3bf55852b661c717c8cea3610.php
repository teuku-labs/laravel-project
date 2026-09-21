<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Seminar LKP - Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{--primary:#2ecc71;--dark:#27ae60;--light:#e8f8f0;--bg:#f8f9fa;--text:#2c3e50;--muted:#6c757d;--sidebar:280px;}
        *{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Poppins',sans-serif;background:var(--bg);color:var(--text);}
        .sidebar{position:fixed;top:0;left:0;width:var(--sidebar);height:100vh;background:linear-gradient(180deg,var(--dark),var(--primary));z-index:1000;overflow-y:auto;}
        .sidebar-header{padding:1.5rem;border-bottom:1px solid rgba(255,255,255,.1);}
        .sidebar-brand{font-size:1.2rem;font-weight:700;color:white;text-decoration:none;display:flex;align-items:center;gap:.75rem;}
        .sidebar-menu{padding:1rem 0;}.menu-cat{padding:.75rem 1.5rem;font-size:.72rem;font-weight:600;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:1px;}
        .menu-item{display:flex;align-items:center;padding:.85rem 1.5rem;color:rgba(255,255,255,.9);text-decoration:none;transition:all .3s;border-left:3px solid transparent;}
        .menu-item:hover,.menu-item.active{background:rgba(255,255,255,.1);color:white;border-left-color:white;}
        .menu-item i{width:22px;margin-right:.75rem;}
        .menu-dropdown-toggle{width:100%;background:none;border:none;cursor:pointer;font-family:inherit;font-size:inherit;}
        .menu-dropdown-toggle .dropdown-arrow{margin-left:auto;font-size:.7rem;transition:transform .25s;}
        .menu-dropdown.open>.menu-dropdown-toggle{background:rgba(255,255,255,.1);color:#fff;}
        .menu-dropdown.open>.menu-dropdown-toggle .dropdown-arrow{transform:rotate(180deg);}
        .menu-dropdown-content{max-height:0;overflow:hidden;transition:max-height .3s ease;}
        .menu-dropdown.open>.menu-dropdown-content{max-height:200px;}
        .menu-dropdown-content .menu-item{padding-left:3.3rem;font-size:.85rem;}
        .badge-menu{margin-left:auto;background:rgba(255,255,255,.2);color:white;font-size:.7rem;padding:.25rem .5rem;border-radius:10px;}
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
        .custom-table thead th{background:var(--light);color:var(--dark);font-weight:600;font-size:.78rem;padding:.7rem .6rem;text-align:center;border:1px solid #eee;vertical-align:middle;}
        .custom-table tbody td{padding:.6rem;border:1px solid #eee;font-size:.85rem;text-align:center;vertical-align:middle;}
        .custom-table tbody tr:hover{background:var(--light);}
        .custom-table tbody td.text-start{text-align:left;}
        .nilai-input{width:65px;padding:.35rem;border:1.5px solid #ddd;border-radius:6px;text-align:center;font-family:'Poppins',sans-serif;font-size:.85rem;}
        .nilai-input:focus{border-color:var(--primary);outline:none;}
        .rata-cell{font-weight:600;color:var(--dark);}
        .badge-huruf{display:inline-block;min-width:28px;padding:.25rem .5rem;border-radius:6px;font-weight:700;font-size:.8rem;background:var(--light);color:var(--dark);}
        .btn-save{background:var(--primary);color:white;border:none;padding:.4rem .9rem;border-radius:8px;font-size:.78rem;cursor:pointer;white-space:nowrap;}
        .btn-save:hover{background:var(--dark);}
        .empty-state{text-align:center;padding:2.5rem;color:var(--muted);}
        .empty-state i{font-size:3rem;color:#dee2e6;margin-bottom:.75rem;}
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.show{transform:translateX(0)}.main{margin-left:0}}
    </style>
</head>
<body>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header"><a href="#" class="sidebar-brand"><i class="fas fa-chalkboard-teacher"></i><span>Dosen Portal</span></a></div>
    <nav class="sidebar-menu">
        <div class="menu-cat">Menu Utama</div>
        <a href="<?php echo e(route('dosen.dashboard')); ?>" class="menu-item"><i class="fas fa-home"></i>Dashboard</a>
        <a href="<?php echo e(route('dosen.jadwal')); ?>" class="menu-item"><i class="fas fa-calendar-alt"></i>Jadwal Saya@if($upcomingJadwal > 0)<span class="badge-menu"><?php echo e($upcomingJadwal); ?></span><?php endif; ?></a>
        <a href="<?php echo e(route('dosen.sk')); ?>" class="menu-item"><i class="fas fa-file-download"></i>Download SK</a>
        <a href="<?php echo e(route('dosen.mahasiswa')); ?>" class="menu-item"><i class="fas fa-user-graduate"></i>Mahasiswa Bimbingan@if($mahasiswaCount > 0)<span class="badge-menu"><?php echo e($mahasiswaCount); ?></span><?php endif; ?></a>
        <div class="menu-cat" style="margin-top:1.5rem;">Penilaian</div>
        <div class="menu-dropdown <?php echo e(request()->routeIs('dosen.nilai-lkp.*','dosen.nilai-proposal.*','dosen.nilai-sidang.*') ? 'open' : ''); ?>">
            <button type="button" class="menu-item menu-dropdown-toggle" onclick="this.closest('.menu-dropdown').classList.toggle('open')">
                <i class="fas fa-star-half-alt"></i>Nilai<i class="fas fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="menu-dropdown-content">
                <a href="<?php echo e(route('dosen.nilai-lkp.index')); ?>" class="menu-item <?php echo e(request()->routeIs('dosen.nilai-lkp.*') ? 'active' : ''); ?>">Nilai Seminar LKP</a>
                <a href="<?php echo e(route('dosen.nilai-proposal.index')); ?>" class="menu-item <?php echo e(request()->routeIs('dosen.nilai-proposal.*') ? 'active' : ''); ?>">Nilai Seminar Proposal</a>
                <a href="<?php echo e(route('dosen.nilai-sidang.index')); ?>" class="menu-item <?php echo e(request()->routeIs('dosen.nilai-sidang.*') ? 'active' : ''); ?>">Nilai Sidang Skripsi</a>
            </div>
        </div>
        <div class="menu-cat" style="margin-top:1.5rem;">Lainnya</div>
        <a href="<?php echo e(route('dosen.profile')); ?>" class="menu-item"><i class="fas fa-user"></i>Profil Saya</a>
        <form action="<?php echo e(route('logout')); ?>" method="POST"><?php echo csrf_field(); ?>
            <button type="submit" class="menu-item" style="width:100%;text-align:left;background:none;border:none;color:inherit;"><i class="fas fa-sign-out-alt"></i>Logout</button>
        </form>
    </nav>
</aside>

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;"><button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button><span style="font-weight:600;font-size:.95rem;">Nilai Seminar LKP</span></div>
        <div style="display:flex;align-items:center;gap:.75rem;"><div class="avatar"><?php echo e(substr($dosen->nama ?? 'D', 0, 1)); ?></div><div><div style="font-weight:600;font-size:.9rem;"><?php echo e($dosen->nama ?? '-'); ?></div><div style="font-size:.75rem;color:var(--muted);">Dosen</div></div></div>
    </nav>

    <div class="content">
        <?php if(session('success')): ?><div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
        <?php if($errors->any()): ?><div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-circle me-2"></i><?php echo e($errors->first()); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

        <div class="table-card">
            <div class="table-header">
                <div>
                    <strong style="font-size:1rem;">Input &amp; Nilai Seminar LKP</strong>
                    <p style="color:var(--muted);font-size:.83rem;margin:0;">Mahasiswa yang Anda bimbing/uji &middot; Total: <?php echo e($seminarList->count()); ?> &middot; <em>Nilai hanya bisa diisi oleh dosen penguji</em></p>
                </div>
                <div class="search-box"><i class="fas fa-search"></i><input type="text" id="searchInput" placeholder="Cari mahasiswa..."></div>
            </div>

            <div class="table-responsive">
                <table class="custom-table" id="nilaiTable">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Judul LKP</th>
                            <th rowspan="2">Nama</th>
                            <th rowspan="2">NIM</th>
                            <th rowspan="2">Peran Saya</th>
                            <th colspan="4">Aspek Penilaian</th>
                            <th rowspan="2">Rata-rata</th>
                            <th rowspan="2">Nilai Huruf</th>
                            <th rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th>Isi Materi</th><th>Penyajian</th><th>Penguasaan Materi</th><th>Sikap Mental</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $seminarList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $nilai = $s->nilai;
                            $formId = 'form-nilai-' . $s->id;
                            $bisaEdit = $s->penguji_id == $dosen->id;
                            $peran = $bisaEdit ? 'Penguji' : 'Pembimbing';
                        ?>
                        <tr>
                            <td><?php echo e($i+1); ?></td>
                            <td class="text-start"><?php echo e(Str::limit($s->judul_lkp, 30)); ?></td>
                            <td class="text-start"><strong><?php echo e($s->mahasiswa->nama ?? '-'); ?></strong></td>
                            <td><?php echo e($s->mahasiswa->nim ?? '-'); ?></td>
                            <td><?php echo e($peran); ?></td>
                            <?php if($bisaEdit): ?>
                            <td><input type="number" step="0.01" min="0" max="100" name="isi_materi" form="<?php echo e($formId); ?>" class="nilai-input" value="<?php echo e(old('isi_materi', $nilai->isi_materi ?? '')); ?>" required></td>
                            <td><input type="number" step="0.01" min="0" max="100" name="penyajian" form="<?php echo e($formId); ?>" class="nilai-input" value="<?php echo e(old('penyajian', $nilai->penyajian ?? '')); ?>" required></td>
                            <td><input type="number" step="0.01" min="0" max="100" name="penguasaan_materi" form="<?php echo e($formId); ?>" class="nilai-input" value="<?php echo e(old('penguasaan_materi', $nilai->penguasaan_materi ?? '')); ?>" required></td>
                            <td><input type="number" step="0.01" min="0" max="100" name="sikap_mental" form="<?php echo e($formId); ?>" class="nilai-input" value="<?php echo e(old('sikap_mental', $nilai->sikap_mental ?? '')); ?>" required></td>
                            <td class="rata-cell"><?php echo e($nilai->rata_rata ?? '-'); ?></td>
                            <td><span class="badge-huruf"><?php echo e($nilai->nilai_huruf ?? '-'); ?></span></td>
                            <td><button type="submit" form="<?php echo e($formId); ?>" class="btn-save"><i class="fas fa-save"></i> Simpan</button></td>
                            <?php else: ?>
                            
                            <td><?php echo e($nilai->isi_materi ?? '-'); ?></td>
                            <td><?php echo e($nilai->penyajian ?? '-'); ?></td>
                            <td><?php echo e($nilai->penguasaan_materi ?? '-'); ?></td>
                            <td><?php echo e($nilai->sikap_mental ?? '-'); ?></td>
                            <td class="rata-cell"><?php echo e($nilai->rata_rata ?? '-'); ?></td>
                            <td><span class="badge-huruf"><?php echo e($nilai->nilai_huruf ?? '-'); ?></span></td>
                            <td><span style="color:var(--muted);font-size:.95rem;" title="Lihat saja"><i class="fas fa-lock"></i></span></td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="11"><div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada seminar LKP yang Anda bimbing/uji.</p></div></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php $__currentLoopData = $seminarList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($s->penguji_id == $dosen->id): ?>
            <form id="form-nilai-<?php echo e($s->id); ?>" action="<?php echo e(route('dosen.nilai-lkp.store', $s->id)); ?>" method="POST" style="display:none;"><?php echo csrf_field(); ?></form>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));
    document.getElementById('searchInput').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#nilaiTable tbody tr').forEach(r => { r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none'; });
    });
</script>
</body>
</html><?php /**PATH C:\laragon\www\seminar-apk\resources\views/dosen/nilai-lkp.blade.php ENDPATH**/ ?>