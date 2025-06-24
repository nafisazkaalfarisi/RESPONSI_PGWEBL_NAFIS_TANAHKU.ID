@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.css" />
    <style>
        #map {
            width: 100%;
            height: calc(100vh - 70px);
        }
    </style>
@endsection

@section('content')
    <div id="map"></div>
    @include('partials.create-modals') {{-- Pastikan file modals dipisah agar rapi --}}
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/@terraformer/wkt"></script>
    <script src="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.js"></script>
    <script src="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.js"></script>

    <script>
        var map = L.map('map', {
            fullscreenControl: true
        }).setView([-7.7972, 110.3688], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.control.locate({
            position: 'topleft',
            strings: {
                title: "Lokasi Saya"
            },
            flyTo: true
        }).addTo(map);

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: {
                position: 'topleft',
                polyline: true,
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
            drawnItems.addLayer(layer);
        });

        const endpoints = {
            point: "{{ route('api.points') }}",
            polyline: "{{ route('api.polylines') }}",
            polygon: "{{ route('api.polygons') }}"
        };

        const layers = {
            point: L.geoJson(null, { pointToLayer: (f, latlng) => L.marker(latlng), onEachFeature: handleFeature('points') }),
            polyline: L.geoJson(null, { style: () => ({ color: 'blue', weight: 4 }), onEachFeature: handleFeature('polylines') }),
            polygon: L.geoJson(null, { style: () => ({ color: 'green', weight: 2, fillOpacity: 0.5 }), onEachFeature: handleFeature('polygons') })
        };

        for (const [type, url] of Object.entries(endpoints)) {
            $.getJSON(url, data => {
                layers[type].addData(data);
                map.addLayer(layers[type]);
            });
        }

        L.control.layers(null, {
            'Points': layers.point,
            'Polylines': layers.polyline,
            'Polygons': layers.polygon
        }, { collapsed: false }).addTo(map);

        function handleFeature(type) {
            return function(feature, layer) {
                let edit = `{{ route('${type}.edit', ':id') }}`.replace(':id', feature.properties.id);
                let del = `{{ route('${type}.destroy', ':id') }}`.replace(':id', feature.properties.id);
                let popup = `<strong>${feature.properties.name}</strong><br>${feature.properties.description}<br>`;
                if (feature.properties.image) popup += `<img src='{{ asset('storage/images') }}/${feature.properties.image}' width='250'><br>`;
                popup += `<a href='${edit}' class='btn btn-warning btn-sm'>Edit</a>
                          <form method='POST' action='${del}' style='display:inline;'>
                            @csrf @method('DELETE')
                            <button type='submit' class='btn btn-danger btn-sm'>Hapus</button>
                          </form>`;
                layer.bindPopup(popup);
                layer.bindTooltip(feature.properties.name);
            }
        }
    </script>
@endsection
