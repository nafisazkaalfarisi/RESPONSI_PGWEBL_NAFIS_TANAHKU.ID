<?php $__env->startSection('content'); ?>
    <div class="container mt-4">

        
        <div class="card shadow-lg mb-5">
            <div class="card-body">
                <h4 class="mb-4">
                    <i class="fa-solid fa-map-pin text-primary me-2"></i>Data Titik Lokasi
                </h4>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="pointstable">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Kontak</th>
                                <th>Lokasi</th>
                                <th>Gambar</th>
                                <th>Dibuat</th>
                                <th>Diperbarui</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($point->name); ?></td>
                                    <td><?php echo e(Str::limit($point->description, 80)); ?></td>
                                    <td>Rp <?php echo e(number_format($point->price, 0, ',', '.')); ?></td>
                                    <td><?php echo e(ucfirst($point->status)); ?></td>
                                    <td><?php echo e($point->contact); ?></td>
                                    <td><?php echo e($point->village ?? '-'); ?></td>
                                    <td class="text-center">
                                        <?php if($point->image): ?>
                                            <img src="<?php echo e(asset('storage/images/' . $point->image)); ?>" alt="Gambar"
                                                width="100" class="rounded shadow-sm">
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($point->created_at->translatedFormat('d M Y H:i')); ?></td>
                                    <td><?php echo e($point->updated_at->translatedFormat('d M Y H:i')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <div class="card shadow-lg">
            <div class="card-body">
                <h4 class="mb-4">
                    <i class="fa-solid fa-draw-polygon text-success me-2"></i>Data Area Tanah
                </h4>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="polygonstable">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Sertifikat</th>
                                <th>Peruntukan</th>
                                <th>Akses Jalan</th>
                                <th>Kabupaten</th>
                                <th>Kecamatan</th>
                                <th>Gambar</th>
                                <th>Dibuat</th>
                                <th>Diperbarui</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $polygons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $polygon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($polygon->name); ?></td>
                                    <td><?php echo e(Str::limit($polygon->description, 80)); ?></td>
                                    <td><?php echo e($polygon->certificate ?? '-'); ?></td>
                                    <td><?php echo e($polygon->land_use ?? '-'); ?></td>
                                    <td><?php echo e($polygon->road_access ?? '-'); ?></td>
                                    <td><?php echo e($polygon->regency ?? '-'); ?></td>
                                    <td><?php echo e($polygon->district ?? '-'); ?></td>
                                    <td class="text-center">
                                        <?php if($polygon->image): ?>
                                            <img src="<?php echo e(asset('storage/images/' . $polygon->image)); ?>" alt="Gambar"
                                                width="100" class="rounded shadow-sm">
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($polygon->created_at->translatedFormat('d M Y H:i')); ?></td>
                                    <td><?php echo e($polygon->updated_at->translatedFormat('d M Y H:i')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <style>
        table img {
            object-fit: cover;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#pointstable', {
                responsive: true,
                pageLength: 5,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "›",
                        previous: "‹"
                    },
                    zeroRecords: "Tidak ada data ditemukan"
                }
            });

            new DataTable('#polygonstable', {
                responsive: true,
                pageLength: 5,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "›",
                        previous: "‹"
                    },
                    zeroRecords: "Tidak ada data ditemukan"
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PGWL_NAFIS\pgwl\resources\views/table.blade.php ENDPATH**/ ?>