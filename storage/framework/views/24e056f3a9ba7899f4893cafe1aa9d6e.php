<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>#map { width: 100%; height: 400px; }</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-3">
    <h4>Edit Titik Tanah</h4>

    <div id="map" class="rounded mb-4 shadow"></div>

    <form method="POST" action="<?php echo e(route('points.update', $point->id)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="<?php echo e($point->name); ?>" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required><?php echo e($point->description); ?></textarea>
        </div>

        <div class="mb-3">
            <label>Harga (Rp)</label>
            <input type="text" id="price_display" class="form-control" value="<?php echo e(number_format($point->price, 0, ',', '.')); ?>" required>
            <input type="hidden" name="price" id="price" value="<?php echo e($point->price); ?>">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="tersedia" <?php echo e($point->status == 'tersedia' ? 'selected' : ''); ?>>Tersedia</option>
                <option value="terjual" <?php echo e($point->status == 'terjual' ? 'selected' : ''); ?>>Terjual</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Kontak</label>
            <input type="text" name="contact" class="form-control" value="<?php echo e($point->contact); ?>" required>
        </div>

        <div class="mb-3">
            <label>Desa/Lokasi</label>
            <input type="text" name="village" class="form-control" value="<?php echo e($point->village); ?>">
        </div>

        <div class="mb-3">
    <label>Geometri</label>
    <textarea name="geom" id="geom" class="form-control" readonly required><?php echo e($point->geom); ?></textarea>
</div>


        <div class="mb-3">
            <label>Foto Lama</label><br>
            <?php if($point->image): ?>
                <img src="<?php echo e(asset('storage/images/' . $point->image)); ?>" width="200" class="mb-2 img-thumbnail">
            <?php endif; ?>
            <input type="file" name="image" class="form-control mt-2" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="<?php echo e(route('map')); ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/@terraformer/wkt"></script>
<script>
    // Tampilkan marker berdasarkan data awal
    const map = L.map('map').setView([<?php echo e($lat); ?>, <?php echo e($lng); ?>], 17);
    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Maxar, Earthstar Geographics',
            maxZoom: 20
        }).addTo(map);

    const marker = L.marker([<?php echo e($lat); ?>, <?php echo e($lng); ?>], { draggable: true }).addTo(map)
        .bindPopup("Lokasi saat ini").openPopup();

    marker.on('dragend', function (e) {
        const latlng = marker.getLatLng();
        const pointGeoJSON = {
            type: "Point",
            coordinates: [latlng.lng, latlng.lat]
        };
        const wkt = Terraformer.geojsonToWKT(pointGeoJSON);
        document.getElementById('geom').value = wkt;

    });

    // Format harga saat diketik
    const priceDisplay = document.getElementById('price_display');
    const priceHidden = document.getElementById('price');

    priceDisplay.addEventListener('input', function(e) {
        const value = this.value.replace(/[^0-9]/g, '');
        const formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value);

        this.value = formatted;
        priceHidden.value = value;
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PGWL_NAFIS\pgwl\resources\views/edit-point.blade.php ENDPATH**/ ?>