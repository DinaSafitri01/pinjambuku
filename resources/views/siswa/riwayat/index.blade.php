@extends('layout.dashboard')

@section('content')
<div class="animate__animated animate__fadeIn">
    <div class="mb-4">
        <h2 class="fw-bold">Riwayat Peminjaman</h2>
        <p class="text-muted">Daftar buku yang sudah kamu pinjam dan status pengembaliannya.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->has('ringkasan'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first('ringkasan') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">Buku</th>
                        <th class="py-3">Tanggal Pinjam</th>
                        <th class="py-3">Batas Kembali</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-end px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $item)
                        @php
                            $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo);
                            $isLate = $item->status == 'dipinjam' && now()->gt($jatuhTempo);
                        @endphp
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width: 40px; height: 55px; min-width: 40px;">
                                        @if($item->buku->foto)
                                            <img src="{{ asset('storage/books/' . $item->buku->foto) }}" class="w-100 h-100" style="object-fit: cover;">
                                        @else
                                            <i class="bi bi-book text-muted opacity-50"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="fw-bold text-dark mb-0">{{ $item->buku->judul }}</p>
                                        <small class="text-muted">{{ $item->buku->penulis }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
                            <td>
                                <span class="{{ $isLate ? 'text-danger fw-bold' : '' }}">
                                    {{ $jatuhTempo->translatedFormat('d F Y') }}
                                </span>
                                @if($isLate)
                                    <br><small class="text-danger fw-bold"><i class="bi bi-exclamation-triangle"></i> Terlambat!</small>
                                @endif
                            </td>
                            <td>
                                @if($item->status == 'dipinjam')
                                    <span class="badge bg-light text-primary rounded-pill px-3">
                                        <i class="bi bi-clock-history me-1"></i> Sedang Dipinjam
                                    </span>
                                @elseif($item->status == 'menunggu_konfirmasi')
                                    <span class="badge bg-light text-warning rounded-pill px-3">
                                        <i class="bi bi-hourglass-split me-1"></i> Menunggu Konfirmasi
                                    </span>
                                @else
                                    <span class="badge bg-light text-success rounded-pill px-3">
                                        <i class="bi bi-check-circle me-1"></i> Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="text-end px-4">
                                @if($item->status == 'dipinjam')
                                    @if($isLate)
                                        <button type="button" class="btn btn-sm btn-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalKembali{{ $item->id }}">
                                            Kembalikan
                                        </button>
                                    @else
                                        <form action="{{ route('siswa.kembali', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Kembalikan buku ini?')">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @endif
                                @elseif($item->status == 'menunggu_konfirmasi')
                                    <span class="text-warning small fw-bold">Diproses Admin</span>
                                @else
                                    <span class="text-muted small">Sudah Kembali</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-clock-history fs-1 d-block mb-3 opacity-25"></i>
                                Kamu belum pernah meminjam buku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('modals')
    @foreach($history as $item)
        @php
            $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo);
            $isLate = $item->status == 'dipinjam' && now()->gt($jatuhTempo);
        @endphp
        @if($isLate)
            <!-- Modal Kembali (Hanya muncul jika terlambat) -->
            <div class="modal fade" id="modalKembali{{ $item->id }}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold" style="color: #1B5E58;">Peringatan Terlambat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('siswa.kembali', $item->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="alert alert-warning border-0 mb-0" style="background: #fff8e1; border-radius: 15px; color: #1B5E58;">
                                    <div class="d-flex gap-3">
                                        <i class="bi bi-exclamation-triangle-fill fs-4 text-warning"></i>
                                        <div>
                                            <p class="fw-bold mb-1">Buku Terlambat Dikembalikan!</p>
                                            <p class="small mb-0">Kamu telah melewati batas waktu peminjaman. Sebagai dendanya, kamu wajib menulis ringkasan dari buku yang dipinjam secara manual di kertas sebelum menyerahkan buku ke petugas perpustakaan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-3">
                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: #1B5E58; border: none;">Saya Mengerti & Kembalikan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
