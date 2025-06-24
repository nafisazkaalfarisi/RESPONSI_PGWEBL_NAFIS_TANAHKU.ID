@extends('layouts.app')

@section('title', 'Notifikasi | Tanahku.id')

@section('content')
    <div class="container">
        <h4 class="mb-4">Notifikasi</h4>

        @forelse ($notifications as $notification)
            <div class="alert alert-info">
                <strong>{{ $notification->data['title'] ?? 'Notifikasi Baru' }}</strong><br>
                <small>{{ $notification->created_at->diffForHumans() }}</small>
                <div>{{ $notification->data['message'] ?? '' }}</div>
            </div>
        @empty
            <p class="text-muted">Belum ada notifikasi.</p>
        @endforelse

        {{ $notifications->links() }}
    </div>
@endsection
