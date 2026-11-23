<?php
    $na = $item->nilaiAkhir();
    $muted = 'color:var(--muted);font-size:.78rem;';
?>
<?php $__currentLoopData = [1, 2]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ke): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $nPenguji = $item->nilaiPengujiKe($ke); ?>
    <td>
        <?php if(!$item->{'penguji'.$ke.'_id'}): ?>
            -
        <?php elseif($nPenguji): ?>
            <?php echo e($nPenguji->rata_rata); ?> <span class="badge-huruf"><?php echo e($nPenguji->nilai_huruf); ?></span>
            <div style="<?php echo e($muted); ?>"><?php echo e($item->{'penguji'.$ke}->nama ?? ''); ?></div>
        <?php else: ?>
            <span style="<?php echo e($muted); ?>">Belum menilai</span>
            <div style="<?php echo e($muted); ?>"><?php echo e($item->{'penguji'.$ke}->nama ?? ''); ?></div>
        <?php endif; ?>
    </td>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<td>
    <?php if($na && $na['lengkap']): ?>
        <strong><?php echo e(number_format($na['rata_rata'], 2)); ?></strong> <span class="badge-huruf"><?php echo e($na['nilai_huruf']); ?></span>
    <?php elseif($na): ?>
        <span style="<?php echo e($muted); ?>">Menunggu penguji lain (<?php echo e($na['jumlah_masuk']); ?>/<?php echo e($na['jumlah_penguji']); ?>)</span>
    <?php else: ?>
        -
    <?php endif; ?>
</td><?php /**PATH C:\laragon\www\seminar-apk\resources\views/partials/nilai-akhir.blade.php ENDPATH**/ ?>