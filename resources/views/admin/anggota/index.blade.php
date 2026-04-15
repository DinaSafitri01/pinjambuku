@extends('layout.dashboard')

@section('content')
<div class="animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Manajemen Anggota</h2>
            <p class="text-muted">Daftar seluruh siswa yang terdaftar sebagai anggota perpustakaan.</p>
        </div>
        <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary rounded-pill px-4" style="background: #1976d2; border: none;">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah Anggota
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
                        <th class="px-4 py-3">NIS</th>
                        <th class="py-3">Nama Lengkap</th>
                        <th class="py-3">Kelas</th>
                        <th class="py-3">Jurusan</th>
                        <th class="py-3">Email</th>
                        <th class="py-3 text-end px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggota as $item)
                        <tr>
                            <td class="px-4"><span class="badge bg-light text-dark fw-medium">{{ $item->nis }}</span></td>
                            <td class="fw-bold text-dark">{{ $item->name }}</td>
                            <td>{{ $item->kelas ?? '-' }}</td>
                            <td>{{ $item->jurusan ?? '-' }}</td>
                            <td>{{ $item->email }}</td>
                            <td class="text-end px-4">
                                <a href="{{ route('admin.anggota.edit', $item->id) }}" class="btn btn-sm btn-light rounded-3 me-2">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.anggota.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger rounded-3" onclick="return confirm('Hapus anggota ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada anggota yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
