<?php $__env->startSection('title', 'Dashboard | Tanahku.id'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4 fw-bold text-primary">📊 Dashboard Tanahku.id</h2>

    
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-primary text-white text-center">
                <div class="card-body">
                    <h6>Total Titik Lokasi</h6>
                    <h2 class="fw-bold"><?php echo e($pointCount); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-success text-white text-center">
                <div class="card-body">
                    <h6>Total Data Tanah</h6>
                    <h2 class="fw-bold"><?php echo e($polygonCount); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-danger text-white text-center">
                <div class="card-body">
                    <h6>Total Pengguna</h6>
                    <h2 class="fw-bold"><?php echo e($userCount); ?></h2>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 id="chartTitle" class="mb-0 text-primary">📍 Distribusi Tanah per Kecamatan</h5>
            <select id="filterType" class="form-select w-auto">
                <option value="kecamatan" selected>Per Kecamatan</option>
                <option value="kabupaten">Per Kabupaten</option>
            </select>
        </div>
        <div class="card-body">
            <canvas id="tanahChart" height="100"></canvas>
        </div>
    </div>

    
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-primary">🆕 Data Tanah Terbaru</h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <?php $__empty_1 = true; $__currentLoopData = $recentPolygons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $polygon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo e($polygon->name); ?></span>
                        <small class="text-muted"><?php echo e($polygon->created_at->diffForHumans()); ?></small>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="list-group-item text-center text-muted">Belum ada data terbaru.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('tanahChart').getContext('2d');

    const dataKecamatan = <?php echo json_encode($chartDataKecamatan); ?>;
    const dataKabupaten = <?php echo json_encode($chartDataKabupaten); ?>;

    function extractChartData(data) {
        return {
            labels: data.map(item => item.label),
            values: data.map(item => item.total)
        };
    }

    let current = extractChartData(dataKecamatan);

    const tanahChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: current.labels,
            datasets: [{
                label: 'Jumlah Tanah',
                data: current.values,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: '#007bff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    document.getElementById('filterType').addEventListener('change', function () {
        const isKab = this.value === 'kabupaten';
        const data = isKab ? extractChartData(dataKabupaten) : extractChartData(dataKecamatan);

        document.getElementById('chartTitle').innerText = isKab
            ? '📍 Distribusi Tanah per Kabupaten'
            : '📍 Distribusi Tanah per Kecamatan';

        tanahChart.data.labels = data.labels;
        tanahChart.data.datasets[0].data = data.values;
        tanahChart.update();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PGWL_NAFIS\pgwl\resources\views/dashboard/index.blade.php ENDPATH**/ ?>