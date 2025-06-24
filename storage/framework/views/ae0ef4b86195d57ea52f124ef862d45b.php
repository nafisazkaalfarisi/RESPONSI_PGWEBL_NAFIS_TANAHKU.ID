<?php $__env->startSection('title', 'Notifikasi | Tanahku.id'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h4 class="mb-4">Notifikasi</h4>

        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="alert alert-info">
                <strong><?php echo e($notification->data['title'] ?? 'Notifikasi Baru'); ?></strong><br>
                <small><?php echo e($notification->created_at->diffForHumans()); ?></small>
                <div><?php echo e($notification->data['message'] ?? ''); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted">Belum ada notifikasi.</p>
        <?php endif; ?>

        <?php echo e($notifications->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PGWL_NAFIS\pgwl\resources\views/notifications.blade.php ENDPATH**/ ?>