@extends('layout.app')

@section('content')
<style>
    .image-text h3, .image-text p {
        color: #ffffff !important;
    }
</style>
<div class="auth-wrapper">
    <div class="card login-card border-0 animate__animated animate__fadeIn">
        <div class="row g-0">

            <!-- LEFT CONTENT -->
            <div class="col-md-6 p-3 p-lg-4 d-flex flex-column justify-content-center">
                <div class="mb-4 text-center">
                    <div class="mb-0">
                        <img src="{{ asset('image/logopinaku.png') }}" alt="PINAKU Logo" class="img-fluid mx-auto" style="max-height: 45px;">
                    </div>
                    <h3 class="fw-bold mb-2">Selamat Datang Di Pinaku<i class="bi bi-hand-wave text-warning"></i></h3>
                    <p class="text-muted">
                        Sistem Peminjaman Buku Online.
                    </p>
                </div>

                <div class="role-selection mb-4">
                    <p class="fw-semibold text-dark mb-2">Silahkan pilih role Anda:</p>

                    <a href="{{ route('login.siswa') }}" class="btn-role">
                        <span class="icon"><i class="bi bi-mortarboard-fill"></i></span>
                        <div class="text-start">
                            <strong>Siswa</strong>
                            <small>Akses perpustakaan & pinjam buku</small>
                        </div>
                    </a>

                    <a href="{{ route('login.admin') }}" class="btn-role">
                        <span class="icon"><i class="bi bi-person-badge-fill"></i></span>
                        <div class="text-start">
                            <strong>Admin / Guru</strong>
                            <small>Kelola data buku & transaksi</small>
                        </div>
                    </a>
                </div>

                <div class="mt-2 text-center">
                    <a href="{{ route('landing') }}" class="btn btn-outline-secondary w-100 py-2 rounded-3 small">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>

            <!-- RIGHT IMAGE -->
            <div class="col-md-6 d-none d-md-block">
                <div class="image-wrapper">
                    <img src="{{ asset('image/welcome.png') }}" alt="Books Library">
                    <div class="image-overlay"></div>
                    <div class="image-text">
                        <h3 class="animate__animated animate__fadeInUp animate__delay-1s">Literasi untuk Masa Depan</h3>
                        <p class="animate__animated animate__fadeInUp animate__delay-1s opacity-75">
                            "Buku adalah jendela dunia. Pinjam sekarang dengan mudah di PINAKU."
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
