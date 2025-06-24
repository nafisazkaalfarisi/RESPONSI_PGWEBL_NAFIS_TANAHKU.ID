@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary">⚙️ Pengaturan</h2>

    <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-1">Tema Tampilan</h5>
                <p class="card-text text-muted">Pilih antara mode terang atau gelap.</p>
            </div>
            <form method="POST" action="{{ route('settings.toggleTheme') }}">
                @csrf
                <button class="btn btn-outline-primary">
                    {{ session('theme', 'light') === 'light' ? '🌙 Mode Gelap' : '☀️ Mode Terang' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
