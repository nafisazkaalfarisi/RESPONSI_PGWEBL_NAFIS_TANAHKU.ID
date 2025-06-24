<?php $__env->startSection('title', 'Beranda | Tanahku.id'); ?>


<?php $__env->startSection('styles'); ?>
    <style>
        .hover-shadow:hover {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
        }

        .badge-custom {
            font-size: 0.75rem;
            padding: 0.4em 0.6em;
            border-radius: 0.5rem;
        }

        .bg-blue {
            background-color: #e7f0ff;
        }

        .dark-mode .bg-blue {
            background-color: #1c2738;
        }

        .dark-mode .text-muted {
            color: #cfcfcf !important;
        }

        .dark-mode .card {
            background-color: #2b2b2b;
            border: 1px solid #444;
        }

        .dark-mode .card .card-text {
            color: #ccc;
        }

        .dark-mode .alert-secondary {
            background-color: #333;
            color: #ccc;
            border-color: #444;
        }

        .dark-mode input,
        .dark-mode .form-control {
            background-color: #222;
            color: #eee;
            border-color: #555;
        }

        .dark-mode .btn-outline-primary {
            color: #9cc6ff;
            border-color: #9cc6ff;
        }

        .dark-mode .btn-outline-primary:hover {
            background-color: #337ab7;
            color: white;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="py-4 px-3">

    
    <div class="bg-blue p-5 rounded shadow-sm mb-5 text-center border">
        <h1 class="fw-bold display-5 mb-2 text-primary">Selamat Datang di <span class="text-success">Tanahku.id</span></h1>
        <p class="text-muted fs-5">Cari dan pasarkan tanah atau lokasi strategis dengan peta interaktif.</p>
        <a href="<?php echo e(route('map')); ?>" class="btn btn-primary btn-lg">🌍 Lihat Peta Interaktif</a>
    </div>

    
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <form method="GET" action="<?php echo e(route('home')); ?>" class="flex-grow-1 me-3">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="🔍 Cari tanah atau titik lokasi..." value="<?php echo e(request('q')); ?>">
                <button class="btn btn-outline-primary">Cari</button>
            </div>
        </form>
        <?php if(auth()->guard()->check()): ?>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('polygons.create')); ?>" class="btn btn-success">+ Tambah Tanah</a>
                <a href="<?php echo e(route('points.create')); ?>" class="btn btn-outline-success">+ Tambah Titik</a>
            </div>
        <?php endif; ?>
    </div>

    
    <h4 class="fw-semibold mb-3 text-primary">🟩 Daftar Tanah</h4>
    <div class="row g-4 mb-5">
        <?php $__empty_1 = true; $__currentLoopData = $polygons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="position-relative">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-success badge-custom">Tanah</span>
                        <img src="<?php echo e($item->image ? asset('storage/images/' . $item->image) : 'https://via.placeholder.com/400x250?text=Tanah'); ?>"
                             class="card-img-top" alt="<?php echo e($item->name); ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-primary"><?php echo e($item->name); ?></h5>
                        <p class="card-text text-muted"><?php echo e(Str::limit($item->description, 90)); ?></p>
                        <a href="<?php echo e(route('map', ['focus_polygon' => $item->id])); ?>" class="btn btn-outline-primary btn-sm">🔍 Detail</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center">
                <div class="alert alert-secondary">Belum ada data tanah.</div>
            </div>
        <?php endif; ?>
    </div>

    
    <h4 class="fw-semibold mb-3 text-primary">📌 Daftar Titik Lokasi</h4>
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="position-relative">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-primary badge-custom">Titik</span>
                        <img src="<?php echo e($item->image ? asset('storage/images/' . $item->image) : 'https://via.placeholder.com/400x250?text=Titik+Lokasi'); ?>"
                             class="card-img-top" alt="<?php echo e($item->name); ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-primary"><?php echo e($item->name); ?></h5>
                        <p class="card-text text-muted"><?php echo e(Str::limit($item->description, 90)); ?></p>
                        <a href="<?php echo e(route('map', ['focus_point' => $item->id])); ?>" class="btn btn-outline-primary btn-sm">📍 Detail</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center">
                <div class="alert alert-secondary">Belum ada data titik lokasi.</div>
            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PGWL_NAFIS\pgwl\resources\views/home.blade.php ENDPATH**/ ?>