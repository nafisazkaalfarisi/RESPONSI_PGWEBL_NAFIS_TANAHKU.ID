@extends('layouts.guest')

@section('title', 'Tanahku.id | Platform Jual Beli Tanah Digital')

@section('styles')
    <style>
        body {
            background-color: #f0f4ff;
        }

        .carousel-item {
            height: 500px;
            position: relative;
        }

        .carousel-item img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .hover-effect {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }


        .hero-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            z-index: 2;
            text-align: center;
            width: 100%;
            padding: 0 1rem;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            color: #0d6efd;
        }

        .feature-icon {
            font-size: 2rem;
            color: #0d6efd;
        }

        .card {
            border: 1px solid #e0e0e0;
        }

        .card h5 {
            color: #0d6efd;
        }

        .btn-outline-primary,
        .btn-outline-success {
            border-width: 2px;
            transition: 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: white;
        }

        .btn-outline-success:hover {
            background-color: #198754;
            color: white;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .badge-custom {
            font-size: 0.75rem;
            padding: 0.4em 0.6em;
            border-radius: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid px-0">

        {{-- Hero Carousel --}}
        <div id="heroCarousel" class="carousel slide carousel-fade mb-5" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1461175827210-5ceac3e39dd2?q=80&w=1033&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100"
                        alt="Slide 1">
                    <div class="hero-overlay"></div>
                    <div class="hero-text">
                        <h1 class="display-4 fw-bold">Selamat Datang di <span class="text-warning">Tanahku.id</span></h1>
                        <p class="fs-5">Temukan dan tawarkan tanah potensial dengan cepat dan mudah melalui peta
                            interaktif.</p>
                        <a href="{{ route('map') }}" class="btn btn-light btn-lg mt-3">🌍 Lihat Peta Tanah</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://plus.unsplash.com/premium_photo-1661899405263-a0bee333068e?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100"
                        alt="Slide 2">
                    <div class="hero-overlay"></div>
                    <div class="hero-text">
                        <h1 class="display-4 fw-bold">Eksplorasi Tanah Impianmu</h1>
                        <p class="fs-5">Pilih lokasi strategis dengan bantuan peta digital interaktif.</p>
                        <a href="{{ route('map') }}" class="btn btn-light btn-lg mt-3">🔍 Telusuri Sekarang</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1737440144855-4cfa958ec63c?q=80&w=928&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100"
                        alt="Slide 3">
                    <div class="hero-overlay"></div>
                    <div class="hero-text">
                        <h1 class="display-4 fw-bold">Jual Cepat & Aman</h1>
                        <p class="fs-5">Unggah tanahmu hanya dalam beberapa klik.</p>
                        <a href="{{ route('map') }}" class="btn btn-warning btn-lg mt-3">+ Tambah Tanah</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Konten Utama --}}
        <div class="container py-4">

            {{-- Fitur Unggulan --}}
            <div class="bg-white p-5 rounded shadow-sm mb-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Mengapa Pilih Tanahku.id?</h2>
                </div>
                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm h-100 hover-effect">
                            <div class="card-body">
                                <i class="fas fa-map-marked-alt feature-icon mb-3"></i>
                                <h5>Peta Interaktif</h5>
                                <p class="text-muted">Visualisasikan lokasi tanah secara akurat dan real-time.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm h-100 hover-effect">
                            <div class="card-body">
                                <i class="fas fa-file-signature feature-icon mb-3"></i>
                                <h5>Data Lengkap</h5>
                                <p class="text-muted">Deskripsi, gambar, dan detail lokasi tanah tersedia lengkap.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm h-100 hover-effect">
                            <div class="card-body">
                                <i class="fas fa-lock feature-icon mb-3"></i>
                                <h5>Aman & Terverifikasi</h5>
                                <p class="text-muted">Hanya pengguna terdaftar yang bisa mengakses dan menambahkan data.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Daftar Tanah Terbaru --}}
            <div class="bg-white p-4 rounded shadow-sm mb-5">
                <h3 class="fw-bold mb-3">🟩 Tanah Terbaru</h3>
                <div class="row g-4">
                    @forelse($polygons as $item)
                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="position-relative">
                                    <span class="badge bg-success badge-custom position-absolute m-2">Tanah</span>
                                    <img src="{{ $item->image ? asset('storage/images/' . $item->image) : 'https://via.placeholder.com/400x250?text=Tanah' }}"
                                        class="card-img-top" alt="{{ $item->name }}">
                                </div>
                                <div class="card-body">
                                    <h5>{{ $item->name }}</h5>
                                    <p class="text-muted">{{ Str::limit($item->description, 80) }}</p>
                                    <a href="{{ route('map', ['focus_polygon' => $item->id]) }}"
                                        class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <div class="alert alert-secondary">Belum ada data tanah yang tersedia.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Titik Lokasi Terbaru --}}
            <div class="bg-white p-4 rounded shadow-sm mb-5">
                <h3 class="fw-bold mb-3">📌 Titik Lokasi Terbaru</h3>
                <div class="row g-4">
                    @forelse($points as $item)
                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="position-relative">
                                    <span class="badge bg-primary badge-custom position-absolute m-2">Titik</span>
                                    <img src="{{ $item->image ? asset('storage/images/' . $item->image) : 'https://via.placeholder.com/400x250?text=Titik+Lokasi' }}"
                                        class="card-img-top" alt="{{ $item->name }}">
                                </div>
                                <div class="card-body">
                                    <h5>{{ $item->name }}</h5>
                                    <p class="text-muted">{{ Str::limit($item->description, 80) }}</p>
                                    <a href="{{ route('map', ['focus_point' => $item->id]) }}"
                                        class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <div class="alert alert-secondary">Belum ada data titik lokasi.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- CTA Tambah Data --}}
            @auth
                <div class="bg-white p-5 rounded shadow-sm text-center">
                    <h4 class="mb-3">Ingin menambahkan tanah atau titik lokasi?</h4>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('polygons.create') }}" class="btn btn-success">+ Tambah Tanah</a>
                        <a href="{{ route('points.create') }}" class="btn btn-outline-success">+ Tambah Titik</a>
                    </div>
                </div>
            @endauth

        </div>
    </div>
@endsection
