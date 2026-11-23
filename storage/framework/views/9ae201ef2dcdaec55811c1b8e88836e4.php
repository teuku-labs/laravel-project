<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download SK - Dekan</title>
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
        .badge-menu{margin-left:auto;background:rgba(255,255,255,.25);color:white;font-size:.7rem;padding:.2rem .5rem;border-radius:10px;}
        .main{margin-left:var(--sidebar);min-height:100vh;}
        .topbar{background:white;box-shadow:0 2px 15px rgba(0,0,0,.05);padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:999;}
        .toggle-btn{background:none;border:none;font-size:1.3rem;color:var(--text);cursor:pointer;}
        .avatar{width:40px;height:40px;background:linear-gradient(135deg,var(--primary),var(--dark));border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;}
        .content{padding:2rem;}
        /* Kartu SK (dipakai partial dosen.partials.sk-cards) */
        .stats-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:1rem;margin-bottom:2rem;}
        .stat-mini{background:white;border-radius:12px;padding:1rem;box-shadow:0 3px 10px rgba(0,0,0,.05);text-align:center;}
        .stat-mini .value{font-size:1.8rem;font-weight:700;color:var(--text);}
        .stat-mini .label{font-size:.8rem;color:var(--muted);}
        .documents-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;}
        .document-card{background:white;border-radius:16px;padding:1.5rem;box-shadow:0 5px 20px rgba(0,0,0,.05);border:1px solid #eee;transition:all .3s;display:flex;flex-direction:column;}
        .document-card:hover{transform:translateY(-5px);box-shadow:0 10px 30px rgba(0,0,0,.1);border-color:var(--primary);}
        .document-icon{width:60px;height:60px;background:var(--light);border-radius:14px;display:flex;align-items:center;justify-content:center;color:var(--dark);font-size:1.5rem;margin-bottom:1rem;}
        .document-title{font-weight:600;font-size:1rem;margin-bottom:.5rem;}
        .document-info{font-size:.85rem;color:var(--muted);margin-bottom:1rem;flex:1;}
        .document-info p{margin:.25rem 0;display:flex;align-items:center;gap:.5rem;}
        .document-info i{color:var(--primary);font-size:.75rem;}
        .btn-download{background:linear-gradient(135deg,var(--primary),var(--dark));border:none;color:white;padding:.75rem;border-radius:10px;font-weight:500;width:100%;transition:all .3s;display:flex;align-items:center;justify-content:center;gap:.5rem;text-decoration:none;font-family:'Poppins',sans-serif;cursor:pointer;}
        .btn-download:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(0,0,0,.2);color:white;}
        .empty-state{text-align:center;padding:3rem 1rem;color:var(--muted);}
        .empty-state i{font-size:4rem;color:#dee2e6;margin-bottom:1rem;}
        .empty-state h5{color:var(--text);margin-bottom:.5rem;}
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.show{transform:translateX(0)}.main{margin-left:0}}
    </style>
</head>
<body>
<?php echo $__env->make('dekan.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;"><button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button><span style="color:var(--muted);font-size:.9rem;">Download SK</span></div>
        <div style="display:flex;align-items:center;gap:.75rem;"><div class="avatar"><?php echo e(substr($dekan->nama ?? 'D', 0, 1)); ?></div><div><div style="font-weight:600;font-size:.9rem;"><?php echo e($dekan->nama); ?></div><div style="font-size:.75rem;color:var(--muted);">Dekan</div></div></div>
    </nav>

    <div class="content">
        <?php if(session('success')): ?><div class="alert alert-success alert-dismissible fade show mb-3"><i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
        <?php if(session('error')): ?><div class="alert alert-danger alert-dismissible fade show mb-3"><i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

        <div style="margin-bottom:2rem;">
            <h2 style="font-weight:700;"><i class="fas fa-file-download" style="color:var(--primary);"></i> Surat Keputusan (SK)</h2>
            <p style="color:var(--muted);font-size:.9rem;">SK Pembimbing dan SK Pembahas yang memuat nama Anda, tersedia setelah diterbitkan dekan</p>
        </div>

        <?php if (! ($punyaDataDosen)): ?>
            <div class="alert alert-warning mb-4"><i class="fas fa-info-circle me-2"></i>Akun Anda belum terhubung dengan data dosen, sehingga belum ada SK yang bisa ditampilkan. Hubungi admin untuk menghubungkannya.</div>
        <?php endif; ?>

        <div class="stats-row">
            <div class="stat-mini"><div class="value"><?php echo e($skItems->count()); ?></div><div class="label">Total SK</div></div>
            <div class="stat-mini"><div class="value" style="color:var(--dark);"><?php echo e($jumlahPembimbing); ?></div><div class="label">SK Pembimbing</div></div>
            <div class="stat-mini"><div class="value" style="color:#3498db;"><?php echo e($jumlahPembahas); ?></div><div class="label">SK Pembahas</div></div>
        </div>

        <?php echo $__env->make('dosen.partials.sk-cards', ['skItems' => $skItems], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>

<script>
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('show');
});
</script>
</body>
</html><?php /**PATH C:\laragon\www\seminar-apk\resources\views/dekan/sk-saya.blade.php ENDPATH**/ ?>