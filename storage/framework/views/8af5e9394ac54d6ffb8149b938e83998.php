<?php $__env->startSection('title', 'Edit Tanah | Tanahku.id'); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-3">
    <h4>Edit Data Tanah (Polygon)</h4>

    <div id="map" class="rounded mb-4 shadow"></div>

    <form method="POST" action="<?php echo e(route('polygons.update', $id)); ?>" enctype="multipart/form-data" id="edit-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Sertifikat</label>
            <input type="text" name="certificate" id="certificate" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Penggunaan Lahan</label>
            <input type="text" name="land_use" id="land_use" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Akses Jalan</label>
            <input type="text" name="road_access" id="road_access" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kecamatan</label>
            <input type="text" name="district" id="district" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Geometri (WKT)</label>
            <textarea name="geom_polygon" id="geom_polygon" class="form-control" readonly required></textarea>
        </div>

        <div class="mb-3">
            <label>Foto Lama</label><br>
            <img src="" id="preview-image" class="img-thumbnail mb-2" width="300">
            <input type="file" name="image" class="form-control mt-2" accept="image/*" onchange="previewImage(event)">
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="<?php echo e(route('map')); ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/@terraformer/wkt"></script>

<script>
    const map = L.map('map').setView([-7.8014, 110.3646], 14);
    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Maxar, Earthstar Geographics',
            maxZoom: 20
        }).addTo(map);

    const drawnItems = new L.FeatureGroup().addTo(map);

    const drawControl = new L.Control.Draw({
        draw: false,
        edit: {
            featureGroup: drawnItems,
            edit: true
        }
    });
    map.addControl(drawControl);

    let editableLayer = null; // << tangkap layer yang akan diedit

    $.getJSON("<?php echo e(route('api.polygons')); ?>", function(data) {
        const layer = L.geoJSON(data, {
            onEachFeature: function(feature, layer) {
                if (feature.properties.id == <?php echo e($id); ?>) {
                    drawnItems.addLayer(layer);
                    map.fitBounds(layer.getBounds());

                    editableLayer = layer;

                    // Isi form
                    $('#name').val(feature.properties.name);
                    $('#description').val(feature.properties.description);
                    $('#certificate').val(feature.properties.certificate);
                    $('#land_use').val(feature.properties.land_use);
                    $('#road_access').val(feature.properties.road_access);
                    $('#district').val(feature.properties.district);
                    $('#geom_polygon').val(Terraformer.geojsonToWKT(feature.geometry));

                    if (feature.properties.image) {
                        $('#preview-image').attr('src', feature.properties.image_url);
                    }
                }
            }
        });
    });

    map.on('draw:edited', function (e) {
        e.layers.eachLayer(function (layer) {
            const geom = Terraformer.geojsonToWKT(layer.toGeoJSON().geometry);
            $('#geom_polygon').val(geom);
            editableLayer = layer; // update layer hasil edit
        });
    });

    // Tangkap submit form dan update geom_polygon terakhir
    $('#edit-form').on('submit', function () {
        if (editableLayer) {
            const updatedWKT = Terraformer.geojsonToWKT(editableLayer.toGeoJSON().geometry);
            $('#geom_polygon').val(updatedWKT);
        }
    });

    function previewImage(event) {
        const image = event.target.files[0];
        const preview = document.getElementById('preview-image');
        if (image) {
            preview.src = URL.createObjectURL(image);
            preview.style.display = 'block';
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PGWL_NAFIS\pgwl\resources\views/edit-polygon.blade.php ENDPATH**/ ?>