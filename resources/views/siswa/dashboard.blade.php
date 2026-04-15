@extends('layout.dashboard')

@section('content')
<div class="animate__animated animate__fadeIn">
    <div class="mb-4">
        <h2 class="fw-bold">Halo, Siswa! <i class="bi bi-hand-wave text-warning"></i></h2>
        <p class="text-muted">Ayo mulai berpetualang dan temukan ilmu baru di perpustakaan.</p>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 text-center rounded-4 h-100" style="background: #ffffff;">
                <div class="icon-box mx-auto mb-3" style="width: 70px; height: 70px; background: #e9f5ee; color: #0e9a7e; display: flex; align-items: center; justify-content: center; border-radius: 20px; font-size: 2rem;">
                    <i class="bi bi-journal-plus"></i>
                </div>
                <h4 class="fw-bold mb-2">Peminjaman Buku</h4>
                <p class="small text-muted mb-4 text-break">Cari buku favoritmu dan buat permohonan pinjam baru dengan cepat.</p>
                <a href="{{ route('siswa.pinjam.index') }}" class="btn btn-primary w-100 rounded-pill py-2" style="background: #0e9a7e; border: none;">Cari Buku Sekarang</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 text-center rounded-4 h-100" style="background: #ffffff;">
                <div class="icon-box mx-auto mb-3" style="width: 70px; height: 70px; background: #fff0f0; color: #d32f2f; display: flex; align-items: center; justify-content: center; border-radius: 20px; font-size: 2rem;">
                    <i class="bi bi-journal-check"></i>
                </div>
                <h4 class="fw-bold mb-2">Pengembalian</h4>
                <p class="small text-muted mb-4 text-break">Kamu sedang meminjam <strong>{{ $currentLoansCount }}</strong> buku saat ini.</p>
                <a href="{{ route('siswa.riwayat') }}" class="btn btn-outline-danger w-100 rounded-pill py-2">Proses Kembali</a>
            </div>
        </div>
    </div>

    <div class="mt-5 card border-0 shadow-sm p-4 rounded-4" style="background: #ffffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-success"></i> Aktivitas Terakhir</h5>
            <a href="{{ route('siswa.riwayat') }}" class="small text-decoration-none text-muted">Lihat Semua</a>
        </div>
        
        @if($recentActivities->count() > 0)
            <div class="table-responsive">
                <table class="table table-borderless align-middle mb-0">
                    <tbody>
                        @foreach($recentActivities as $activity)
                            <tr>
                                <td style="width: 50px;">
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width: 40px; height: 55px; min-width: 40px;">
                                        @if($activity->buku->foto)
                                            <img src="{{ asset('storage/books/' . $activity->buku->foto) }}" class="w-100 h-100" style="object-fit: cover;">
                                        @else
                                            <i class="bi bi-book text-muted opacity-50"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 fw-bold">{{ $activity->buku->judul }}</p>
                                    <small class="text-muted">{{ $activity->status == 'dipinjam' ? 'Dipinjam pada' : 'Dikembalikan pada' }} {{ \Carbon\Carbon::parse($activity->updated_at)->translatedFormat('d F Y') }}</small>
                                </td>
                                <td class="text-end">
                                    <span class="badge bg-light {{ $activity->status == 'dipinjam' ? 'text-primary' : 'text-success' }} rounded-pill px-3">
                                        {{ ucfirst($activity->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted small py-4 text-center italic">Belum ada riwayat aktivitas peminjaman terbaru.</p>
        @endif
    </div>
</div>
@endsection
