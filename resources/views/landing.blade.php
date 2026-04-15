@extends('layout.app')

@section('content')
<div class="container-fluid p-0 overflow-x-hidden position-relative">
    <!-- Top Nav -->
    <div class="position-absolute top-0 end-0 p-4" style="z-index: 1000;">
        <a href="{{ route('welcome') }}" class="btn btn-light rounded-pill px-4 py-2 fw-bold shadow-lg transform-hover">
            Masuk <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>

    <!-- Hero Section -->
    <section class="hero-section min-vh-100 d-flex align-items-center position-relative" style="background: linear-gradient(135deg, #1f5f59 0%, #16423e 100%); padding-top: 80px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 animate__animated animate__fadeInLeft">
                    <h6 class="text-uppercase tracking-widest fw-bold mb-3" style="color: #4ade80; letter-spacing: 4px;">SOLUSI PERPUSTAKAAN MODERN</h6>
                    <h1 class="fs-3 fw-bold text-white mb-4 line-height-1 text-nowrap">PINAKU: Pinjam Buku Jadi Lebih Mudah</h1>
                    <div class="mb-4 rounded-pill bg-white" style="width: 550px; max-width: 100%; height: 2px; opacity: 0.85;"></div>
                    <p class="lead text-white opacity-75 mb-4 pe-lg-5">Kelola koleksi buku Anda, akses literasi tanpa batas, dan nikmati pengalaman meminjam buku yang cepat, transparan, dan terintegrasi dalam satu platform.</p>
                    <div class="d-flex gap-3">
                        <a href="#features" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block animate__animated animate__fadeInRight">
                    <div class="position-relative">
                        <div class="position-absolute translate-middle-y top-50 start-50 rounded-circle" style="width: 500px; height: 500px; background: rgba(74, 222, 128, 0.1); filter: blur(80px); z-index: 1;"></div>
                        <img src="image/landing.png" alt="Library" class="img-fluid rounded-5 shadow-2xl position-relative" style="z-index: 2; border: 8px solid rgba(255,255,255,0.1); animation: float 6s ease-in-out infinite;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5 animate__animated animate__fadeInUp">
                <h2 class="fw-bold display-5" style="color: #1B5E58;">Mengapa Memilih PINAKU?</h2>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                    <div class="card border-0 shadow-sm p-5 rounded-4 h-100 text-center hover-up">
                        <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px; background: #e9f5ee; color: #0e9a7e; display: flex; align-items: center; justify-content: center; border-radius: 25px; font-size: 2rem;">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h4 class="fw-bold" style="color: #1B5E58;">Cepat & Efisien</h4>
                        <p class="text-muted" style="color: #1B5E58 !important;">Proses peminjaman dan pengembalian dilakukan secara digital, mengurangi waktu antrean.</p>
                    </div>
                </div>
                <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    <div class="card border-0 shadow-sm p-5 rounded-4 h-100 text-center hover-up border-primary-glow">
                        <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px; background: #fff8e1; color: #ffa000; display: flex; align-items: center; justify-content: center; border-radius: 25px; font-size: 2rem;">
                            <i class="bi bi-shield-fill-check"></i>
                        </div>
                        <h4 class="fw-bold" style="color: #1B5E58;">Aman & Terpercaya</h4>
                        <p class="text-muted" style="color: #1B5E58 !important;">Data anggota dan koleksi buku tersimpan aman di database server sekolah yang terenkripsi.</p>
                    </div>
                </div>
                <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                    <div class="card border-0 shadow-sm p-5 rounded-4 h-100 text-center hover-up">
                        <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px; background: #e3f2fd; color: #1976d2; display: flex; align-items: center; justify-content: center; border-radius: 25px; font-size: 2rem;">
                            <i class="bi bi-phone-vibrate-fill"></i>
                        </div>
                        <h4 class="fw-bold" style="color: #1B5E58;">Akses Kapan Saja</h4>
                        <p class="text-muted" style="color: #1B5E58 !important;">Cek status ketersediaan buku favoritmu langsung dari ponsel pintarmu di mana saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Area -->
    <footer class="pt-5 pb-3 text-white" style="background: #16423e; border-top: 1px solid rgba(255,255,255,0.1);">
        <div class="container pb-4">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="mb-1 footer-logo-glow">
                        <img src="{{ asset('image/logopinaku.png') }}" alt="PINAKU Logo" class="img-fluid" style="max-height: 150px; filter: drop-shadow(0 0 10px #fff) drop-shadow(0 0 20px #fff) drop-shadow(0 0 40px rgba(255,255,255,0.8)) drop-shadow(0 0 60px rgba(255,255,255,0.6));">
                    </div>
                    <p class="opacity-75 mb-4 pe-lg-5">
                        Aplikasi sistem perpustakaan digital yang dirancang untuk memudahkan siswa dan admin dalam mengelola koleksi buku serta transaksi peminjaman secara efisien.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6 ps-lg-5">
                    <h5 class="fw-bold mb-3">Tautan Cepat</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#features">Fitur Utama</a></li>
                        <li><a href="{{ route('welcome') }}">Mulai Kini</a></li>
                        <li><a href="#">Panduan</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Kontak Sekolah</h5>
                    <ul class="list-unstyled footer-links opacity-75">
                        <li class="mb-2 d-flex align-items-start">
                            <i class="bi bi-geo-alt-fill me-2 mt-1" style="color: #4ade80;"></i>
                            <span>Jl. Veteran No.1A, Babakan, Kec. Tangerang, Kota Tangerang, Banten 15118</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <i class="bi bi-telephone-fill me-2" style="color: #4ade80;"></i>
                            <span>(021)5523429</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <i class="bi bi-envelope-fill me-2" style="color: #4ade80;"></i>
                            <span>info@vhttps://smkn4-tng.sch.id/</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container border-top border-white border-opacity-10 pt-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="opacity-50 small mb-0">&copy; 2026 Dikembangkan oleh Rahmadina Safitri.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">

                </div>
            </div>
        </div>
    </footer>
</div>

<style>
    footer, footer h1, footer h2, footer h3, footer h4, footer h5, footer h6, footer p, footer label, footer span {
        color: #ffffff !important;
    }

    .line-height-1 { line-height: 1.1; }
    .transform-hover { transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .transform-hover:hover { transform: scale(1.05); }
    .hover-up { transition: all 0.3s ease; }
    .hover-up:hover { transform: translateY(-15px); }
    .border-primary-glow:hover { box-shadow: 0 10px 30px rgba(14, 154, 126, 0.15); }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }

    .social-icon {
        width: 38px;
        height: 38px;
        background: rgba(255,255,255,0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .social-icon:hover {
        background: #4ade80;
        color: #16423e;
        transform: translateY(-3px);
    }
    .footer-links li { margin-bottom: 0.75rem; }
    .footer-links a {
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .footer-links a:hover {
        color: #4ade80;
        padding-left: 5px;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
</style>
@endsection
