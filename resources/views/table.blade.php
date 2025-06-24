@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Tabel Titik Lokasi --}}
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
                            @foreach ($points as $point)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $point->name }}</td>
                                    <td>{{ Str::limit($point->description, 80) }}</td>
                                    <td>Rp {{ number_format($point->price, 0, ',', '.') }}</td>
                                    <td>{{ ucfirst($point->status) }}</td>
                                    <td>{{ $point->contact }}</td>
                                    <td>{{ $point->village ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($point->image)
                                            <img src="{{ asset('storage/images/' . $point->image) }}" alt="Gambar"
                                                width="100" class="rounded shadow-sm">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>{{ $point->created_at->translatedFormat('d M Y H:i') }}</td>
                                    <td>{{ $point->updated_at->translatedFormat('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tabel Area Tanah --}}
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
                            @foreach ($polygons as $polygon)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $polygon->name }}</td>
                                    <td>{{ Str::limit($polygon->description, 80) }}</td>
                                    <td>{{ $polygon->certificate ?? '-' }}</td>
                                    <td>{{ $polygon->land_use ?? '-' }}</td>
                                    <td>{{ $polygon->road_access ?? '-' }}</td>
                                    <td>{{ $polygon->regency ?? '-' }}</td>
                                    <td>{{ $polygon->district ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($polygon->image)
                                            <img src="{{ asset('storage/images/' . $polygon->image) }}" alt="Gambar"
                                                width="100" class="rounded shadow-sm">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>{{ $polygon->created_at->translatedFormat('d M Y H:i') }}</td>
                                    <td>{{ $polygon->updated_at->translatedFormat('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <style>
        table img {
            object-fit: cover;
        }
    </style>
@endsection

@section('scripts')
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
@endsection
