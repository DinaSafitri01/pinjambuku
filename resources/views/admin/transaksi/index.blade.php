@extends('layout.dashboard')

@section('content')
<div class="animate__animated animate__fadeIn">
    <div class="mb-4">
        <h2 class="fw-bold">Pantau Transaksi</h2>
        <p class="text-muted">Lihat seluruh riwayat peminjaman dan pengembalian buku.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">Siswa</th>
                        <th class="py-3">Buku</th>
                        <th class="py-3">Tgl Pinjam</th>
                        <th class="py-3">Jatuh Tempo</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 text-end px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        @php
                            $isLate = ($loan->status == 'dipinjam' || $loan->status == 'menunggu_konfirmasi') && now()->gt($loan->tanggal_jatuh_tempo);
                        @endphp
                        <tr>
                            <td class="px-4">
                                <p class="mb-0 fw-bold text-dark">{{ $loan->user->name }}</p>
                                <small class="text-muted">{{ $loan->user->nis }}</small>
                            </td>
                            <td>
                                <p class="mb-0 fw-bold text-dark">{{ $loan->buku->judul }}</p>
                                <small class="text-muted">{{ $loan->buku->penulis }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td>
                                <span class="{{ $isLate ? 'text-danger fw-bold' : '' }}">
                                    {{ \Carbon\Carbon::parse($loan->tanggal_jatuh_tempo)->format('d/m/Y') }}
                                </span>
                                @if($isLate)
                                    <br><small class="badge bg-danger p-1" style="font-size: 0.65rem;">TERLAMBAT</small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($loan->status == 'dipinjam')
                                    <span class="badge bg-light text-primary rounded-pill px-3">Dipinjam</span>
                                @elseif($loan->status == 'menunggu_konfirmasi')
                                    <span class="badge bg-light text-warning rounded-pill px-3">Menunggu Konfirmasi</span>
                                @else
                                    <span class="badge bg-light text-success rounded-pill px-3">Selesai</span>
                                @endif
                            </td>
                            <td class="text-end px-4">
                                @if($loan->status == 'menunggu_konfirmasi')
                                    <div class="d-flex justify-content-end gap-2">
                                        <form action="{{ route('admin.konfirmasi-kembali', $loan->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3" onclick="return confirm('Konfirmasi bahwa buku dan ringkasan fisik sudah diterima?')">
                                                Konfirmasi
                                            </button>
                                        </form>
                                    </div>
                                @elseif($loan->status == 'dikembalikan')
                                    <small class="text-success fw-bold"><i class="bi bi-check-all"></i> Terverifikasi</small>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-arrow-left-right fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada transaksi peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
