@extends('layout.dashboard')

@section('content')
<div class="animate__animated animate__fadeIn">
    <div class="mb-4">
        <h2 class="fw-bold">Selamat Datang, Admin! <i class="bi bi-hand-wave text-warning"></i></h2>
        <p class="text-muted">Kelola operasional perpustakaan melalui ringkasan di bawah ini.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-4 text-center rounded-4 h-100" style="background: #ffffff;">
                <div class="icon-box mx-auto mb-3" style="width: 60px; height: 60px; background: #e9f5ee; color: #0e9a7e; display: flex; align-items: center; justify-content: center; border-radius: 15px; font-size: 1.5rem;">
                    <i class="bi bi-book-half"></i>
                </div>
                <h5 class="fw-bold mb-1">Data Buku</h5>
                <p class="small text-muted mb-4 text-break">{{ number_format($totalBuku) }} Total Koleksi</p>
                <a href="{{ route('admin.buku.index') }}" class="btn btn-primary w-100 rounded-pill" style="background: #0e9a7e; border: none;">Kelola</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-4 text-center rounded-4 h-100" style="background: #ffffff;">
                <div class="icon-box mx-auto mb-3" style="width: 60px; height: 60px; background: #fff8e1; color: #ffa000; display: flex; align-items: center; justify-content: center; border-radius: 15px; font-size: 1.5rem;">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <h5 class="fw-bold mb-1">Transaksi</h5>
                <p class="small text-muted mb-4 text-break">{{ $transaksiHariIni }} Pinjaman Hari Ini</p>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-warning w-100 rounded-pill text-white" style="border: none;">Pantau</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-4 text-center rounded-4 h-100" style="background: #ffffff; position: relative;">
                @if($pendingConfirmation > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="z-index: 10;">
                        {{ $pendingConfirmation }}
                        <span class="visually-hidden">pending confirmations</span>
                    </span>
                @endif
                <div class="icon-box mx-auto mb-3" style="width: 60px; height: 60px; background: #fff0f0; color: #d32f2f; display: flex; align-items: center; justify-content: center; border-radius: 15px; font-size: 1.5rem;">
                    <i class="bi bi-patch-check"></i>
                </div>
                <h5 class="fw-bold mb-1">Konfirmasi</h5>
                <p class="small text-muted mb-4 text-break">{{ $pendingConfirmation }} Butuh Verifikasi</p>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-danger w-100 rounded-pill" style="background: #d32f2f; border: none;">Cek Sekarang</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-4 text-center rounded-4 h-100" style="background: #ffffff;">
                <div class="icon-box mx-auto mb-3" style="width: 60px; height: 60px; background: #e3f2fd; color: #1976d2; display: flex; align-items: center; justify-content: center; border-radius: 15px; font-size: 1.5rem;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h5 class="fw-bold mb-1">Anggota</h5>
                <p class="small text-muted mb-4 text-break">{{ $totalAnggota }} Siswa Terdaftar</p>
                <a href="{{ route('admin.anggota.index') }}" class="btn btn-primary w-100 rounded-pill" style="background: #1976d2; border: none;">Manajemen</a>
            </div>
        </div>
    </div>

    <div class="mt-5 card border-0 shadow-sm p-4 rounded-4" style="background: #ffffff;">
        <h5 class="fw-bold mb-3">Statistik Peminjaman</h5>
        <div class="text-center py-5">
            <i class="bi bi-bar-chart-line text-muted mb-3" style="font-size: 3rem;"></i>
            <p class="text-muted">Grafik statistik akan segera hadir di sini.</p>
        </div>
    </div>
</div>
@endsection
