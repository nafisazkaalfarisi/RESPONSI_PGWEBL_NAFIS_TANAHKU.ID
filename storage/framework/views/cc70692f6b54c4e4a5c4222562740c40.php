<?php $__env->startSection('title', 'Pengaturan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2 class="mb-4 text-primary">⚙️ Pengaturan</h2>

    <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-1">Tema Tampilan</h5>
                <p class="card-text text-muted">Pilih antara mode terang atau gelap.</p>
            </div>
            <form method="POST" action="<?php echo e(route('settings.toggleTheme')); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-outline-primary">
                    <?php echo e(session('theme', 'light') === 'light' ? '🌙 Mode Gelap' : '☀️ Mode Terang'); ?>

                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PGWL_NAFIS\pgwl\resources\views/settings.blade.php ENDPATH**/ ?>