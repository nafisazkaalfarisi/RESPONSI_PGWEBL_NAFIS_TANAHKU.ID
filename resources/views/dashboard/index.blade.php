@extends('layouts.app')

@section('title', 'Dashboard | Tanahku.id')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold text-primary">📊 Dashboard Tanahku.id</h2>

    {{-- Statistik --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-primary text-white text-center">
                <div class="card-body">
                    <h6>Total Titik Lokasi</h6>
                    <h2 class="fw-bold">{{ $pointCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-success text-white text-center">
                <div class="card-body">
                    <h6>Total Data Tanah</h6>
                    <h2 class="fw-bold">{{ $polygonCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-danger text-white text-center">
                <div class="card-body">
                    <h6>Total Pengguna</h6>
                    <h2 class="fw-bold">{{ $userCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart --}}
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

    {{-- Data Terbaru --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-primary">🆕 Data Tanah Terbaru</h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @forelse($recentPolygons as $polygon)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $polygon->name }}</span>
                        <small class="text-muted">{{ $polygon->created_at->diffForHumans() }}</small>
                    </li>
                @empty
                    <li class="list-group-item text-center text-muted">Belum ada data terbaru.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('tanahChart').getContext('2d');

    const dataKecamatan = {!! json_encode($chartDataKecamatan) !!};
    const dataKabupaten = {!! json_encode($chartDataKabupaten) !!};

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
@endsection
