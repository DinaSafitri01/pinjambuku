@extends('layout.dashboard')

@section('content')
<div class="animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Pinjam Buku</h2>
            <p class="text-muted">Temukan dan pinjam buku favoritmu sekarang.</p>
        </div>
        <div style="width: 300px;">
            <form action="{{ route('siswa.pinjam.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control rounded-start-pill ps-4 border-0 shadow-sm" placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
                    <button class="btn btn-primary rounded-end-pill px-4" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($buku as $item)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden card-book hover-up" data-bs-toggle="modal" data-bs-target="#modalBuku{{ $item->id }}" style="cursor: pointer;">
                    <div class="position-relative" style="height: 300px;">
                        @if($item->foto)
                            <img src="{{ asset('storage/books/' . $item->foto) }}" class="card-img-top w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                <i class="bi bi-book fs-1 opacity-25"></i>
                            </div>
                        @endif
                        <div class="position-absolute top-0 end-0 m-3">
                            @if($item->stok > 0)
                                <span class="badge bg-success rounded-pill px-3 shadow-sm">Tersedia</span>
                            @else
                                <span class="badge bg-danger rounded-pill px-3 shadow-sm">Tidak Tersedia</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-1 text-truncate">{{ $item->judul }}</h5>
                        <p class="text-muted small mb-3">{{ $item->penulis }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold small">Stok: {{ $item->stok }}</span>
                            <button class="btn btn-sm btn-light rounded-pill px-3">Detail</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-search fs-1 text-muted opacity-25 d-block mb-3"></i>
                <p class="text-muted">Buku tidak ditemukan.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .card-book {
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .card-book:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    .hover-up:hover {
        transform: translateY(-5px);
    }
</style>
@endsection

@section('modals')
    @foreach($buku as $item)
        <!-- Modal Detail -->
        <div class="modal fade" id="modalBuku{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 rounded-4 overflow-hidden">
                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <div class="col-md-5">
                                @if($item->foto)
                                    <img src="{{ asset('storage/books/' . $item->foto) }}" class="w-100 h-100" style="object-fit: cover; min-height: 400px;">
                                @else
                                    <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted" style="min-height: 400px;">
                                        <i class="bi bi-book fs-1 opacity-25"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-7 p-5">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <h3 class="fw-bold mb-0">{{ $item->judul }}</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="row g-3 mb-5">
                                    <div class="col-6">
                                        <p class="text-muted small mb-1">Penulis</p>
                                        <p class="fw-semibold mb-0">{{ $item->penulis }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted small mb-1">Penerbit</p>
                                        <p class="fw-semibold mb-0">{{ $item->penerbit }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted small mb-1">Tahun Terbit</p>
                                        <p class="fw-semibold mb-0">{{ $item->tahun_terbit }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted small mb-1">Ketersediaan</p>
                                        <p class="mb-0">
                                            <span class="badge {{ $item->stok > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill px-3">
                                                {{ $item->stok }} Buku
                                            </span>
                                        </p>
                                        <div class="d-flex justify-content-between mt-3">
                                            <div> <p class="text-muted small mb-0">Tanggal Pinjam</p>
                                                <p>{{  now()->format('d-m-Y') }}</p></div>
                                           <div><p class="text-muted small mb-0">Tanggal Kembali</p>
                                                    <p>{{ now()->addDays(10)->format('d-m-Y') }}</p></div>

                                        </div>
                                    </div>
                                </div>

                                @if($item->stok > 0)
                                    <form action="{{ route('siswa.pinjam.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="buku_id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-primary rounded-pill w-100 py-3 fw-bold" style="background: var(--primary-color, #0e9a7e); border: none;">
                                            Pinjam Sekarang
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary rounded-pill w-100 py-3 fw-bold" disabled>
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
