<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Tanahku.id') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f9f9f9;
        }

        footer {
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
            padding: 2rem 0;
        }

        .nav-link.active {
            font-weight: bold;
        }

        .auth-wrapper {
            min-height: 100vh;
        }

        .auth-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        /* Tambahan styling profesional biru */
        .navbar {
            transition: background-color 0.3s ease;
        }

        .navbar-brand {
            font-size: 1.2rem;
        }

        .navbar-nav .nav-link {
            color: white !important;
            transition: color 0.2s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107 !important;
            text-decoration: underline;
        }

        .navbar-nav .nav-link.active {
            color: #ffc107 !important;
        }

        .btn {
            transition: all 0.3s ease;
        }
    </style>

    @yield('styles')
</head>

<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="{{ route('landing') }}">
                <i class="fas fa-seedling me-2"></i> Tanahku.id
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                            href="{{ route('landing') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
                            href="{{ route('about') }}">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}">Kontak</a>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a class="btn btn-outline-light ms-3" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-warning ms-2 text-dark" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container my-5">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer>
        <div class="container text-center">
            <p class="mb-1">&copy; {{ date('Y') }} Tanahku.id — Platform Pemetaan & Jual Beli Tanah</p>
            <div class="d-flex justify-content-center gap-3 mb-2">
                <a href="https://instagram.com/yourtanahkuid" target="_blank" class="text-decoration-none text-dark">
                    <i class="fab fa-instagram"></i> @tanahku.id
                </a>
                <a href="mailto:support@tanahku.id" class="text-decoration-none text-dark">
                    <i class="fas fa-envelope"></i> support@tanahku.id
                </a>
                <a href="https://wa.me/6281234567890" class="text-decoration-none text-dark" target="_blank">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')

</body>

</html>
