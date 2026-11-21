<aside class="sidebar" id="sidebar">
    <div class="sidebar-header"><a href="#" class="sidebar-brand"><i class="fas fa-user-tie"></i><span>Kaprodi Panel</span></a></div>
    <nav class="sidebar-menu">
        <div class="menu-cat">Menu Utama</div>
        <a href="<?php echo e(route('kaprodi.dashboard')); ?>" class="menu-item <?php echo e(request()->routeIs('kaprodi.dashboard') ? 'active' : ''); ?>"><i class="fas fa-home"></i>Dashboard</a>
        <a href="<?php echo e(route('kaprodi.bimbingan.index')); ?>" class="menu-item <?php echo e(request()->routeIs('kaprodi.bimbingan.*') ? 'active' : ''); ?>"><i class="fas fa-chalkboard-teacher"></i>Bimbingan</a>
        <a href="<?php echo e(route('kaprodi.seminar')); ?>" class="menu-item <?php echo e(request()->routeIs('kaprodi.seminar') ? 'active' : ''); ?>"><i class="fas fa-clipboard-list"></i>Seminar LKP</a>
        <a href="<?php echo e(route('kaprodi.proposal.index')); ?>" class="menu-item <?php echo e(request()->routeIs('kaprodi.proposal.*') ? 'active' : ''); ?>"><i class="fas fa-file-alt"></i>Seminar Proposal</a>
        <a href="<?php echo e(route('kaprodi.sidang.index')); ?>" class="menu-item <?php echo e(request()->routeIs('kaprodi.sidang.*') ? 'active' : ''); ?>"><i class="fas fa-gavel"></i>Sidang</a>
        <a href="<?php echo e(route('kaprodi.jadwal-saya')); ?>" class="menu-item <?php echo e(request()->routeIs('kaprodi.jadwal-saya') ? 'active' : ''); ?>"><i class="fas fa-calendar-alt"></i>Jadwal Saya</a>
        <a href="<?php echo e(route('kaprodi.nilai-lkp.index')); ?>" class="menu-item <?php echo e(request()->routeIs('kaprodi.nilai-lkp.*') ? 'active' : ''); ?>"><i class="fas fa-star-half-alt"></i>Nilai Seminar LKP</a>
        <a href="<?php echo e(route('kaprodi.nilai-proposal.index')); ?>" class="menu-item <?php echo e(request()->routeIs('kaprodi.nilai-proposal.*') ? 'active' : ''); ?>"><i class="fas fa-star-half-alt"></i>Nilai Seminar Proposal</a>
        <a href="<?php echo e(route('kaprodi.nilai-sidang.index')); ?>" class="menu-item <?php echo e(request()->routeIs('kaprodi.nilai-sidang.*') ? 'active' : ''); ?>"><i class="fas fa-star-half-alt"></i>Nilai Sidang Skripsi</a>
        <a href="<?php echo e(route('kaprodi.sk-pembimbing.index')); ?>" class="menu-item <?php echo e(request()->routeIs('kaprodi.sk-pembimbing.*') ? 'active' : ''); ?>"><i class="fas fa-file-signature"></i>SK Pembimbing</a>
        <div class="menu-cat" style="margin-top:1.5rem;">Lainnya</div>
        <a href="<?php echo e(route('kaprodi.profile')); ?>" class="menu-item <?php echo e(request()->routeIs('kaprodi.profile') ? 'active' : ''); ?>"><i class="fas fa-user"></i>Profil Saya</a>
        <form action="<?php echo e(route('logout')); ?>" method="POST"><?php echo csrf_field(); ?><button type="submit" class="menu-item" style="width:100%;text-align:left;background:none;border:none;color:inherit;"><i class="fas fa-sign-out-alt"></i>Logout</button></form>
    </nav>
</aside><?php /**PATH C:\laragon\www\seminar-apk\resources\views/kaprodi/partials/sidebar.blade.php ENDPATH**/ ?>