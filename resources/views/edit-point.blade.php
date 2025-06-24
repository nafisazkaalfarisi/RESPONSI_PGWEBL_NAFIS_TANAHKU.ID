@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>#map { width: 100%; height: 400px; }</style>
@endsection

@section('content')
<div class="container mt-3">
    <h4>Edit Titik Tanah</h4>

    <div id="map" class="rounded mb-4 shadow"></div>

    <form method="POST" action="{{ route('points.update', $point->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $point->name }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required>{{ $point->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Harga (Rp)</label>
            <input type="text" id="price_display" class="form-control" value="{{ number_format($point->price, 0, ',', '.') }}" required>
            <input type="hidden" name="price" id="price" value="{{ $point->price }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="tersedia" {{ $point->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="terjual" {{ $point->status == 'terjual' ? 'selected' : '' }}>Terjual</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Kontak</label>
            <input type="text" name="contact" class="form-control" value="{{ $point->contact }}" required>
        </div>

        <div class="mb-3">
            <label>Desa/Lokasi</label>
            <input type="text" name="village" class="form-control" value="{{ $point->village }}">
        </div>

        <div class="mb-3">
    <label>Geometri</label>
    <textarea name="geom" id="geom" class="form-control" readonly required>{{ $point->geom }}</textarea>
</div>


        <div class="mb-3">
            <label>Foto Lama</label><br>
            @if ($point->image)
                <img src="{{ asset('storage/images/' . $point->image) }}" width="200" class="mb-2 img-thumbnail">
            @endif
            <input type="file" name="image" class="form-control mt-2" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('map') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/@terraformer/wkt"></script>
<script>
    // Tampilkan marker berdasarkan data awal
    const map = L.map('map').setView([{{ $lat }}, {{ $lng }}], 17);
    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Maxar, Earthstar Geographics',
            maxZoom: 20
        }).addTo(map);

    const marker = L.marker([{{ $lat }}, {{ $lng }}], { draggable: true }).addTo(map)
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
@endsection
