@extends('layout.dashboard')

@section('content')
<div class="animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Manajemen Buku</h2>
            <p class="text-muted">Kelola koleksi buku yang tersedia di perpustakaan.</p>
        </div>
        <a href="{{ route('admin.buku.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Tambah Buku
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3" style="width: 80px;">Sampul</th>
                        <th class="py-3">Judul</th>
                        <th class="py-3">Penulis</th>
                        <th class="py-3">Penerbit</th>
                        <th class="py-3 text-center">Tahun</th>
                        <th class="py-3 text-center">Stok</th>
                        <th class="py-3 text-end px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $item)
                        <tr>
                            <td class="px-4">
                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center overflow-hidden shadow-sm" style="width: 50px; height: 70px;">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/books/' . $item->foto) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="bi bi-book text-muted opacity-50"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="fw-bold text-dark">{{ $item->judul }}</td>
                            <td>{{ $item->penulis }}</td>
                            <td>{{ $item->penerbit }}</td>
                            <td class="text-center">{{ $item->tahun_terbit }}</td>
                            <td class="text-center">
                                <span class="badge {{ $item->stok > 0 ? 'bg-light text-success' : 'bg-light text-danger' }} rounded-pill px-3">
                                    {{ $item->stok }}
                                </span>
                            </td>
                            <td class="text-end px-4">
                                <a href="{{ route('admin.buku.edit', $item->id) }}" class="btn btn-sm btn-light rounded-3 me-2">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger rounded-3" onclick="return confirm('Hapus buku ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-book fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada koleksi buku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
