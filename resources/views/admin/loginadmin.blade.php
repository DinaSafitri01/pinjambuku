@extends('layouts.auth')
@section('title', 'Login Admin')

@section('content')
<div class="card auth-card text-white p-4" style="width: 100%; max-width: 400px;">
    <div class="card-body">
        <h3 class="text-center fw-bold mb-1">LOGIN ADMIN</h3>
        <p class="text-center small opacity-75 mb-4">Masukkan kredensial untuk mengelola perpustakaan</p>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3 text-start">
                <label class="form-label small">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan Username Admin" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label small">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
            </div>

            <div class="text-end mb-4">
                <a href="#" class="text-white text-decoration-none small opacity-75">Lupa Password?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-custom fw-bold mb-2 shadow">Masuk</button>
            <a href="{{ route('welcome') }}" class="btn btn-outline-light w-100 btn-custom small">Kembali ke Pilihan Role</a>
        </form>
    </div>
</div>
@endsection
