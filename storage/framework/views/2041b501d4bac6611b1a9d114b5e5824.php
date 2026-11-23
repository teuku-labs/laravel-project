
<div class="documents-grid">
    <?php $__empty_1 = true; $__currentLoopData = $skItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="document-card">
            <div class="document-icon"><i class="fas fa-file-word"></i></div>
            <div class="document-title"><?php echo e($sk->jenis); ?></div>
            <div class="document-info">
                <p><i class="fas fa-user-tag"></i> Peran Anda: <strong><?php echo e($sk->peran); ?></strong></p>
                <p><i class="fas fa-user-graduate"></i> <?php echo e($sk->mahasiswa); ?></p>
                <p><i class="fas fa-id-card"></i> <?php echo e($sk->nim); ?></p>
                <p><i class="fas fa-hashtag"></i> <?php echo e($sk->nomor_sk); ?></p>
                <p><i class="fas fa-calendar"></i> <?php echo e(\App\Models\PengajuanSk::tanggalIndonesia($sk->tanggal)); ?></p>
            </div>
            <a href="<?php echo e($sk->url); ?>" class="btn-download">
                <i class="fas fa-download"></i> Unduh SK (Word)
            </a>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="grid-column:1/-1;">
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <h5>Belum Ada SK</h5>
                <p>SK Pembimbing dan SK Pembahas yang memuat nama Anda akan muncul di sini setelah diterbitkan dekan.</p>
            </div>
        </div>
    <?php endif; ?>
</div><?php /**PATH C:\laragon\www\seminar-apk\resources\views/dosen/partials/sk-cards.blade.php ENDPATH**/ ?>