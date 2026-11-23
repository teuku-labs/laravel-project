<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan SK ke Dekan - Kaprodi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{--primary:#6c5ce7;--dark:#5a4bd1;--light:#f0eeff;--bg:#f8f9fa;--text:#2c3e50;--muted:#6c757d;--sidebar:280px;}
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Poppins',sans-serif;background:var(--bg);color:var(--text);}
        .sidebar{position:fixed;top:0;left:0;width:var(--sidebar);height:100vh;background:linear-gradient(180deg,var(--dark),var(--primary));z-index:1000;overflow-y:auto;}
        .sidebar-header{padding:1.5rem;border-bottom:1px solid rgba(255,255,255,0.1);}
        .sidebar-brand{font-size:1.2rem;font-weight:700;color:white;text-decoration:none;display:flex;align-items:center;gap:.75rem;}
        .sidebar-menu{padding:1rem 0;}
        .menu-cat{padding:.75rem 1.5rem;font-size:.72rem;font-weight:600;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:1px;}
        .menu-item{display:flex;align-items:center;padding:.85rem 1.5rem;color:rgba(255,255,255,.9);text-decoration:none;transition:all .3s;border-left:3px solid transparent;}
        .menu-item:hover,.menu-item.active{background:rgba(255,255,255,.1);color:white;border-left-color:white;}
        .menu-item i{width:22px;margin-right:.75rem;}
        .main{margin-left:var(--sidebar);min-height:100vh;}
        .topbar{background:white;box-shadow:0 2px 15px rgba(0,0,0,.05);padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:999;}
        .toggle-btn{background:none;border:none;font-size:1.3rem;color:var(--text);cursor:pointer;}
        .avatar{width:40px;height:40px;background:linear-gradient(135deg,var(--primary),var(--dark));border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;}
        .uname{font-weight:600;font-size:.9rem;}
        .urole{font-size:.75rem;color:var(--muted);}
        .content{padding:2rem;}
        .stats-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:1rem;margin-bottom:1.5rem;}
        .stat-mini{background:white;border-radius:12px;padding:1rem;box-shadow:0 3px 10px rgba(0,0,0,.05);text-align:center;}
        .stat-mini .value{font-size:1.8rem;font-weight:700;}
        .stat-mini .label{font-size:.8rem;color:var(--muted);}
        .info-box{background:var(--light);border-left:4px solid var(--primary);border-radius:10px;padding:.9rem 1.1rem;font-size:.85rem;margin-bottom:1.5rem;}
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
        .chip{display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .55rem;border-radius:20px;font-size:.74rem;font-weight:600;white-space:nowrap;}
        .chip.ok{background:#e8f8f0;color:#27ae60;}
        .chip.wait{background:#fff4e0;color:#e67e22;}
        .chip.done{background:#e8f0ff;color:#2d6cdf;}
        .alasan{font-size:.76rem;color:var(--muted);text-align:left;margin-top:.35rem;line-height:1.35;}
        .btn-kirim{background:var(--primary);color:white;border:none;padding:.45rem .95rem;border-radius:8px;font-size:.78rem;cursor:pointer;white-space:nowrap;font-family:'Poppins',sans-serif;}
        .btn-kirim:hover{background:var(--dark);}
        .btn-kirim:disabled{background:#d6d6dc;cursor:not-allowed;}
        .btn-semua{background:linear-gradient(135deg,var(--primary),var(--dark));color:white;border:none;padding:.7rem 1.3rem;border-radius:10px;font-size:.88rem;font-weight:500;cursor:pointer;font-family:'Poppins',sans-serif;}
        .btn-semua:disabled{background:#d6d6dc;cursor:not-allowed;}
        .empty-state{text-align:center;padding:2.5rem;color:var(--muted);}
        .empty-state i{font-size:3rem;color:#dee2e6;margin-bottom:.75rem;}
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.show{transform:translateX(0)}.main{margin-left:0}}
    </style>
</head>
<body>
<?php echo $__env->make('kaprodi.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;">
            <button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <span style="color:var(--muted);font-size:.9rem;">Ajukan SK ke Dekan</span>
        </div>
        <div style="display:flex;align-items:center;gap:.75rem;">
            <div class="avatar"><?php echo e(substr($kaprodi->nama ?? 'K', 0, 1)); ?></div>
            <div><div class="uname"><?php echo e($kaprodi->nama ?? '-'); ?></div><div class="urole">Kaprodi</div></div>
        </div>
    </nav>

    <div class="content">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> <?php echo e($errors->first()); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="stats-row">
            <div class="stat-mini">
                <div class="value" style="color:#27ae60;"><?php echo e($jumlahSiap); ?></div>
                <div class="label">Siap diajukan</div>
            </div>
            <div class="stat-mini">
                <div class="value" style="color:#e67e22;"><?php echo e($jumlahBelum); ?></div>
                <div class="label">Nilai belum lengkap</div>
            </div>
            <div class="stat-mini">
                <div class="value" style="color:#2d6cdf;"><?php echo e($jumlahDiteruskan); ?></div>
                <div class="label">Sudah diteruskan ke dekan</div>
            </div>
        </div>

        <div class="info-box">
            <i class="fas fa-info-circle"></i>
             Setelah kedua dosen pembahas menginput seluruh nilai
            Seminar Proposal, Anda dapat meneruskan mahasiswa tersebut ke dekan untuk dibuatkan
            SK Pembimbing dan SK Pembahas. SK yang terbit hanya dapat dilihat dan diunduh oleh dosen bersangkutan.
        </div>

        <div class="table-card">
            <div class="table-header">
                <div>
                    <strong style="font-size:1rem;">Daftar Mahasiswa</strong>
                    <p style="color:var(--muted);font-size:.83rem;margin:0;">Total: <?php echo e($baris->count()); ?> mahasiswa yang sudah mendaftar seminar proposal</p>
                </div>
                <div style="display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Cari mahasiswa...">
                    </div>
                    <form action="<?php echo e(route('kaprodi.sk-dekan.teruskan-semua')); ?>" method="POST"
                          onsubmit="return confirm('Teruskan <?php echo e($jumlahSiap); ?> mahasiswa yang siap ke dekan?');">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-semua" <?php echo e($jumlahSiap > 0 ? '' : 'disabled'); ?>>
                            <i class="fas fa-paper-plane"></i> Teruskan Semua yang Siap (<?php echo e($jumlahSiap); ?>)
                        </button>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="custom-table" id="skTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Nilai Proposal (Pembahas)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $baris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($i + 1); ?></td>
                            <td class="text-start"><strong><?php echo e($b->m->nama); ?></strong></td>
                            <td><?php echo e($b->m->nim); ?></td>
                            <td>
                                <span class="chip <?php echo e($b->nilai['lengkap'] ? 'ok' : 'wait'); ?>">
                                    <i class="fas <?php echo e($b->nilai['lengkap'] ? 'fa-check-circle' : 'fa-clock'); ?>"></i>
                                    <?php echo e($b->nilai['masuk']); ?>/<?php echo e($b->nilai['total']); ?> pembahas
                                </span>
                            </td>
                            <td>
                                <?php if($b->diteruskan): ?>
                                    <span class="chip done"><i class="fas fa-paper-plane"></i> Diteruskan ke dekan</span>
                                <?php elseif($b->siap): ?>
                                    <span class="chip ok"><i class="fas fa-check-circle"></i> Siap diajukan</span>
                                <?php else: ?>
                                    <span class="chip wait"><i class="fas fa-hourglass-half"></i> Belum lengkap</span>
                                    <div class="alasan">
                                        <?php $__currentLoopData = $b->kurang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alasan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            &bull; <?php echo e(ucfirst($alasan)); ?><br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($b->diteruskan): ?>
                                    <span style="font-size:.76rem;color:var(--muted);"><i class="fas fa-lock"></i> Terkirim</span>
                                <?php else: ?>
                                    <form action="<?php echo e(route('kaprodi.sk-dekan.teruskan', $b->m->id)); ?>" method="POST"
                                          onsubmit="return confirm('Teruskan <?php echo e(addslashes($b->m->nama)); ?> ke dekan untuk pembuatan SK?');">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn-kirim" <?php echo e($b->siap ? '' : 'disabled'); ?>>
                                            <i class="fas fa-paper-plane"></i> Ajukan ke Dekan
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6"><div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada mahasiswa yang mendaftar seminar proposal di prodi Anda.</p></div></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));
    document.getElementById('searchInput').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#skTable tbody tr').forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>
</body>
</html><?php /**PATH C:\laragon\www\seminar-apk\resources\views/kaprodi/sk-dekan/index.blade.php ENDPATH**/ ?>