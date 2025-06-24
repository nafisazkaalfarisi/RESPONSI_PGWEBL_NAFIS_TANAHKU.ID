<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body.bg-dark #map {
            filter: brightness(0.9);
        }

        body.bg-dark .modal-content {
            background-color: #2b2b2b;
            color: white;
        }

        body.bg-dark .form-control,
        body.bg-dark .form-select {
            background-color: #1e1e1e;
            color: white;
            border: 1px solid #444;
        }

        #map {
            width: 100%;
            height: calc(100vh - 56px);
        }

        .leaflet-control-layers {
            background-color: #0d6efd !important;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            padding: 8px;
        }

        .leaflet-control-layers label {
            display: block;
            color: white;
        }

        .modal-content {
            border-radius: 10px;
            border: 1px solid #0d6efd;
        }

        .modal-header {
            background-color: #0d6efd;
            color: white;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="map"></div>

    <?php if(session('success')): ?>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert"
                aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo e(session('success')); ?>

                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <!-- Modal Create Point -->
    <div class="modal fade" id="CreatePointModal" tabindex="-1" aria-labelledby="createPointLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="<?php echo e(route('points.store')); ?>" enctype="multipart/form-data" class="modal-content">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Titik Tanah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Harga (Rp)</label>
                        <input type="text" id="price_display" class="form-control" required>
                        <input type="hidden" name="price" id="price">
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="terjual">Terjual</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Kontak</label>
                        <input type="text" name="contact" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Desa/Lokasi</label>
                        <input type="text" name="village" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Geometri</label>
                        <textarea name="geom" id="geom_point" class="form-control" readonly required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Foto</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Create Polygon -->
    <div class="modal fade" id="CreatePolygonModal" tabindex="-1" aria-labelledby="createPolygonLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="<?php echo e(route('polygons.store')); ?>" enctype="multipart/form-data" class="modal-content">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="createPolygonLabel">Tambah Area Tanah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_polygon" class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" id="name_polygon" required>
                    </div>
                    <div class="mb-3">
                        <label for="description_polygon" class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" id="description_polygon" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="certificate" class="form-label">Jenis Sertifikat</label>
                        <select name="certificate" class="form-control" required>
                            <option value="">-- Pilih Sertifikat --</option>
                            <option value="SHM">SHM</option>
                            <option value="SHGB">SHGB</option>
                            <option value="AJB">AJB</option>
                            <option value="Girik">Girik</option>
                            <option value="Petok D">Petok D</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="land_use" class="form-label">Peruntukan Lahan</label>
                        <select name="land_use" class="form-control" required>
                            <option value="">-- Pilih Peruntukan --</option>
                            <option value="Perumahan">Perumahan</option>
                            <option value="Sawah">Sawah</option>
                            <option value="Industri">Industri</option>
                            <option value="Kebun">Kebun</option>
                            <option value="Kosong">Kosong</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="road_access" class="form-label">Akses Jalan</label>
                        <select name="road_access" class="form-control" required>
                            <option value="">-- Pilih Akses --</option>
                            <option value="Sempit">Sempit</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Lebar">Lebar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="regency" class="form-label">Kabupaten/Kota</label>
                        <select name="regency" id="regency" class="form-control" required>
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                            <option value="Bantul">Bantul</option>
                            <option value="Gunungkidul">Gunungkidul</option>
                            <option value="Kulon Progo">Kulon Progo</option>
                            <option value="Sleman">Sleman</option>
                            <option value="Kota Yogyakarta">Kota Yogyakarta</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="district" class="form-label">Kecamatan</label>
                        <select name="district" id="district" class="form-control" required>
                            <option value="">-- Pilih Kecamatan --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="geom_polygon" class="form-label">Geometri</label>
                        <textarea name="geom_polygon" id="geom_polygon" class="form-control" readonly required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image_polygon" class="form-label">Foto</label>
                        <input type="file" name="image" id="image_polygon" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/@terraformer/wkt"></script>

    <script>
        const focusPointId = "<?php echo e($focus_point_id ?? ''); ?>";
        const focusPolygonId = "<?php echo e($focus_polygon_id ?? ''); ?>";
    </script>


    <script>
        const kecamatanDIY = {
            'Bantul': ['Bambanglipuro', 'Banguntapan', 'Bantul', 'Dlingo', 'Imogiri', 'Jetis', 'Kasihan', 'Kretek',
                'Pajangan', 'Pandak', 'Piyungan', 'Pleret', 'Pundong', 'Sanden', 'Sedayu', 'Srandakan'
            ],
            'Gunungkidul': ['Gedangsari', 'Girisubo', 'Karangmojo', 'Ngawen', 'Nglipar', 'Paliyan', 'Panggang', 'Patuk',
                'Playen', 'Ponjong', 'Purwosari', 'Rongkop', 'Saptosari', 'Semanu', 'Semin', 'Tanjungsari', 'Tepus',
                'Wonosari'
            ],
            'Kulon Progo': ['Galur', 'Girimulyo', 'Kalibawang', 'Kokap', 'Lendah', 'Nanggulan', 'Panjatan', 'Pengasih',
                'Samigaluh', 'Sentolo', 'Temon', 'Wates'
            ],
            'Sleman': ['Berbah', 'Cangkringan', 'Depok', 'Gamping', 'Godean', 'Kalasan', 'Minggir', 'Mlati', 'Moyudan',
                'Ngaglik', 'Ngemplak', 'Pakem', 'Seyegan', 'Sleman', 'Tempel', 'Turi'
            ],
            'Kota Yogyakarta': ['Danurejan', 'Gedongtengen', 'Gondokusuman', 'Gondomanan', 'Jetis', 'Kotagede',
                'Kraton', 'Mantrijeron', 'Mergangsan', 'Ngampilan', 'Pakualaman', 'Tegalrejo', 'Umbulharjo',
                'Wirobrajan'
            ]
        };

        $('#regency').on('change', function() {
            const selectedRegency = $(this).val();
            const kecamatan = kecamatanDIY[selectedRegency] || [];

            $('#district').empty().append(`<option value="">-- Pilih Kecamatan --</option>`);
            kecamatan.forEach(function(namaKec) {
                $('#district').append(`<option value="${namaKec}">${namaKec}</option>`);
            });
        });

        // Inject focus ID dari session (jika ada)
        <?php if(session('focus_id')): ?>
            let focusId = "<?php echo e(session('focus_id')); ?>";
        <?php else: ?>
            let focusId = null;
        <?php endif; ?>

        // Inisialisasi peta
        var map = L.map('map');

        // Batas DIY (sekitar)
        var boundsDIY = L.latLngBounds([
            [-8.1, 110.1], // Southwest corner (titik pojok kiri bawah)
            [-7.5, 110.7] // Northeast corner (titik pojok kanan atas)
        ]);

        map.fitBounds(boundsDIY);

        // Tile layer
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Maxar, Earthstar Geographics',
            maxZoom: 20
        }).addTo(map);

        // Tambahkan layer batas dari GeoServer
        var batasDIY = L.tileLayer.wms("http://localhost:8080/geoserver/sig/wms", {
            layers: 'sig:DIY',
            format: 'image/png',
            transparent: true,
            attribution: "GeoServer",
            opacity: 0.4
        });

        batasDIY.addTo(map);

        // Grup fitur hasil digitasi
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: {
                position: 'topleft',
                polyline: false,
                polygon: true,
                rectangle: true,
                circle: false,
                marker: true,
                circlemarker: false
            },
            edit: false
        });
        map.addControl(drawControl);

        map.on('draw:created', function(e) {
            var type = e.layerType,
                layer = e.layer;
            var drawnJSONObject = layer.toGeoJSON();
            var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);
            drawnItems.addLayer(layer);

            if (type === 'polyline') {
                $('#geom_polyline').val(objectGeometry);
                $('#CreatePolylineModal').modal('show');
            } else if (type === 'polygon' || type === 'rectangle') {
                $('#geom_polygon').val(objectGeometry);
                $('#CreatePolygonModal').modal('show');
            } else if (type === 'marker') {
                $('#geom_point').val(objectGeometry);
                $('#CreatePointModal').modal('show');
            }
        });

        // Fungsi untuk load dan tampilkan point, polyline, polygon
        function loadLayer(url, layerGroup, styleCallback, popupCallback) {
            $.getJSON(url, function(data) {
                L.geoJson(data, {
                    style: styleCallback,
                    pointToLayer: function(feature, latlng) {
                        return L.marker(latlng);
                    },
                    onEachFeature: popupCallback
                }).addTo(layerGroup);
                map.addLayer(layerGroup);
            });
        }

        // GeoJSON Point
        var pointLayer = new L.LayerGroup();
        loadLayer("<?php echo e(route('api.points')); ?>", pointLayer, null, function(feature, layer) {
            var routeDelete = "<?php echo e(route('points.destroy', ':id')); ?>".replace(':id', feature.properties.id);
            var routeEdit = "<?php echo e(route('points.edit', ':id')); ?>".replace(':id', feature.properties.id);

            var popupContent = `
    <div class="card shadow-sm border-0" style="width: 18rem;">
        <img src="${feature.properties.image_url}" class="card-img-top" style="height:180px; object-fit:cover;" alt="${feature.properties.name}">
        <div class="card-body">
            <h5 class="card-title">${feature.properties.name}</h5>
            <p class="card-text small">${feature.properties.description}</p>
            <ul class="list-group list-group-flush mb-2">
                <li class="list-group-item"><strong>Harga:</strong> ${formatRupiah(feature.properties.price)}</li>
                <li class="list-group-item"><strong>Status:</strong> ${feature.properties.status}</li>
                <li class="list-group-item"><strong>Kontak:</strong> ${feature.properties.contact}</li>
                <li class="list-group-item"><strong>Lokasi:</strong> ${feature.properties.village}</li>
            </ul>
            <div class="d-flex justify-content-between">
                <a href="${routeEdit}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                <form method="POST" action="${routeDelete}" onsubmit="return confirm('Yakin hapus data ini?')">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>
`;



            layer.bindPopup(popupContent);

            if (focusPointId && feature.properties.id == focusPointId) {
                map.setView(layer.getLatLng(), 18);
                layer.openPopup();
            }


            layer.on('click', function() {
                map.panTo(layer.getBounds ? layer.getBounds() : layer.getLatLng().toBounds(
                    500)); // Zoom ke fitur
                layer.setStyle && layer.setStyle({
                    color: 'orange'
                }); // Highlight jika polygon
            });
            layer.bindTooltip(feature.properties.name);
        });

        // GeoJSON Polygon
        var polygonLayer = new L.LayerGroup();
        loadLayer("<?php echo e(route('api.polygons')); ?>", polygonLayer, function() {
            return {
                color: 'green',
                weight: 2,
                fillOpacity: 0.5
            };
        }, function(feature, layer) {
            var routeDelete = "<?php echo e(route('polygons.destroy', ':id')); ?>".replace(':id', feature.properties.id);
            var routeEdit = "<?php echo e(route('polygons.edit', ':id')); ?>".replace(':id', feature.properties.id);
            var popupContent = `
    <div class="card shadow-sm border-0" style="width: 18rem;">
        <img src="/storage/images/${feature.properties.image}" class="card-img-top" style="height:180px; object-fit:cover;" alt="${feature.properties.name}">
        <div class="card-body">
            <h5 class="card-title">${feature.properties.name}</h5>
            <p class="card-text small">Dibuat oleh: <strong>${feature.properties.user_name || 'Tidak diketahui'}</strong></p>
            <ul class="list-group list-group-flush mb-2">
                <li class="list-group-item"><strong>Sertifikat:</strong> ${feature.properties.certificate}</li>
                <li class="list-group-item"><strong>Peruntukan:</strong> ${feature.properties.land_use}</li>
                <li class="list-group-item"><strong>Luas:</strong> ${feature.properties.area_hektar} hektar</li>
                <li class="list-group-item"><strong>Akses Jalan:</strong> ${feature.properties.road_access}</li>
                <li class="list-group-item"><strong>Kabupaten:</strong> ${feature.properties.regency}</li>
                <li class="list-group-item"><strong>Kecamatan:</strong> ${feature.properties.district}</li>
            </ul>
            <div class="d-flex justify-content-between">
                <a href="${routeEdit}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                <form method="POST" action="${routeDelete}" onsubmit="return confirm('Yakin hapus data ini?')">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger delete-feature" data-id="${feature.properties.id}" data-type="polygon">Hapus</button>
                </form>
            </div>
        </div>
    </div>
`;

            layer.bindPopup(popupContent);

            if (focusPolygonId && feature.properties.id == focusPolygonId) {
                map.fitBounds(layer.getBounds());
                layer.openPopup();
            }


            layer.on('click', function() {
                map.panTo(layer.getBounds ? layer.getBounds() : layer.getLatLng().toBounds(
                    500)); // Zoom ke fitur
                layer.setStyle && layer.setStyle({
                    color: 'orange'
                }); // Highlight jika polygon
            });
            layer.bindTooltip(feature.properties.name);
        });

        // Layer control
        L.control.layers(null, {
            "Batas Administrasi DIY": batasDIY,
            "Points": pointLayer,
            "Polygons": polygonLayer
        }, {
            collapsed: false
        }).addTo(map);

        // Format harga Rupiah saat input
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

        $(document).on('click', '.delete-feature', function() {
            const id = $(this).data('id');
            const type = $(this).data('type');
            const url = type === 'point' ?
                "<?php echo e(route('points.destroy', ':id')); ?>".replace(':id', id) :
                "<?php echo e(route('polygons.destroy', ':id')); ?>".replace(':id', id);

            if (confirm('Yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function() {
                        alert('Berhasil dihapus');
                        location.reload(); // Atau hapus layer dari peta langsung
                    }
                });
            }
        });

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        <?php if(session('success')): ?>
            const toastEl = document.getElementById('successToast');
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PGWL_NAFIS\pgwl\resources\views/map.blade.php ENDPATH**/ ?>