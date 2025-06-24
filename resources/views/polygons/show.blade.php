<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            Detail Tanah: {{ $polygon->name }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-4xl mx-auto space-y-4">
        @if($polygon->image)
            <img src="{{ asset('storage/' . $polygon->image) }}" class="w-full h-64 object-cover rounded" alt="Gambar Tanah">
        @endif

        <p class="text-gray-700">{{ $polygon->description }}</p>

        <div id="map" class="h-96 rounded shadow"></div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const map = L.map('map').setView([-7.8, 110.4], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                const geojson = @json(json_decode($polygon->geom)); // pastikan ini GeoJSON

                const polygonLayer = L.geoJSON(geojson).addTo(map);
                map.fitBounds(polygonLayer.getBounds());
            });
        </script>
    @endpush
</x-app-layout>
