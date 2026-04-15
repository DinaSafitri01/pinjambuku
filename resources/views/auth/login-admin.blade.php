@extends('layout.app')

@section('content')
<div class="auth-wrapper">
    <div class="card p-4" style="width:380px; background:white;">
        <h4 class="text-center mb-2">LOGIN ADMIN</h4>
        <p class="text-center small">Masukkan kredensial untuk mengakses perpustakaan</p>

        <form method="POST" action="{{ route('login.admin.auth') }}">
            @csrf

            @if(session('success'))
                <div class="alert alert-success small py-2">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger small py-2">{{ $errors->first() }}</div>
            @endif

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control shadow-sm" placeholder="Masukkan Email" required value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <div class="input-group shadow-sm">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <script>
                document.getElementById('togglePassword').addEventListener('click', function (e) {
                    const passwordInput = document.getElementById('password');
                    const icon = document.getElementById('toggleIcon');
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    }
                });
            </script>

            <button class="btn btn-primary w-100">Masuk</button>

            <div class="text-center mt-3">
                <p class="small mb-0">Belum punya akun? <a href="{{ route('register.admin') }}" class="fw-bold text-decoration-none" style="color: #0e9a7e;">Daftar di sini</a></p>
            </div>

            <hr class="my-4 opacity-25">

            <a href="{{ route('welcome') }}" class="btn btn-secondary w-100">
                Kembali ke Pilihan Role
            </a>
        </form>
    </div>
</div>

@endsection
