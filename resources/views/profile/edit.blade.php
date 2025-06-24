@extends('layouts.app')

@section('title', 'Profil | Tanahku.id')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Flash Message --}}
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Profil Card --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Profil Pengguna</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ auth()->user()->profile_photo
                        ? asset('storage/' . auth()->user()->profile_photo)
                        : asset('default-avatar.png') }}"
                        class="rounded-circle mb-3 border border-3"
                        width="140" height="140" style="object-fit: cover;" alt="Profile Photo">

                    <h5>{{ auth()->user()->name }}</h5>
                    <p class="text-muted">{{ auth()->user()->email }}</p>

                    <button class="btn btn-outline-primary mt-3" onclick="toggleEdit()">
                        <i class="fas fa-edit me-1"></i> Edit Profil
                    </button>
                </div>
            </div>

            {{-- Edit Form --}}
            <div class="card shadow-sm border-0 mb-4 d-none" id="editProfileCard">
                <div class="card-header bg-light fw-bold">Edit Informasi Profil</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input name="name" type="text" value="{{ old('name', auth()->user()->name) }}"
                                   class="form-control @error('name') is-invalid @enderror" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" value="{{ old('email', auth()->user()->email) }}"
                                   class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="profile_photo" accept="image/*"
                                   class="form-control @error('profile_photo') is-invalid @enderror">
                            @error('profile_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="toggleEdit()">
                                <i class="fas fa-times me-1"></i> Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Ganti Password --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light fw-bold">Ganti Password</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-1"></i> Ganti Password
                        </button>
                    </form>
                </div>
            </div>

            {{-- Hapus Akun --}}
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body text-center">
                    <form method="POST" action="{{ route('profile.destroy') }}"
                          onsubmit="return confirm('Yakin ingin menghapus akun secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Hapus Akun
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleEdit() {
        document.getElementById('editProfileCard').classList.toggle('d-none');
    }
</script>
@endsection
