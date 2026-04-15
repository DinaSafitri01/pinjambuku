@extends('layout.app')

@section('content')
<div class="auth-wrapper">
    <div class="card p-4 animate__animated animate__fadeIn" style="width:400px; background:white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <h4 class="text-center mb-2 fw-bold" style="color: #1B5E58;">REGISTRASI ADMIN</h4>
        <p class="text-center small mb-4" style="color: #1B5E58; opacity: 0.8;">Buat akun admin baru untuk mengelola perpustakaan</p>

        <form method="POST" action="{{ route('register.admin.store') }}">
            @csrf

            @if($errors->any())
                <div class="alert alert-danger small py-2">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label small fw-bold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control shadow-sm" placeholder="Masukkan Nama Lengkap" required value="{{ old('name') }}" style="border-radius: 10px;">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Email</label>
                <input type="email" name="email" class="form-control shadow-sm" placeholder="Masukkan Email" required value="{{ old('email') }}" style="border-radius: 10px;">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Password</label>
                <input type="password" name="password" class="form-control shadow-sm" placeholder="Masukkan Password" required style="border-radius: 10px;">
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control shadow-sm" placeholder="Ulangi Password" required style="border-radius: 10px;">
            </div>

            <button class="btn btn-primary w-100 fw-bold py-2 mb-3" style="background: #0e9a7e; border: none; border-radius: 10px;">Daftar Sekarang</button>

            <div class="text-center mt-2">
                <p class="small mb-0" style="color: #1B5E58;">Sudah punya akun? <a href="{{ route('login.admin') }}" class="fw-bold text-decoration-none" style="color: #0e9a7e;">Login di sini</a></p>
            </div>
            
            <hr class="my-4 opacity-25">
            
            <a href="{{ route('welcome') }}" class="btn btn-outline-secondary w-100 py-2 small" style="border-radius: 10px;">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Pilihan Role
            </a>
        </form>
    </div>
</div>
@endsection
