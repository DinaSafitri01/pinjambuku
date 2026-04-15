@extends('layout.dashboard')

@section('content')
<div class="animate__animated animate__fadeIn" style="max-width: 800px;">
    <div class="mb-4">
        <a href="{{ route('admin.buku.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
        <h2 class="fw-bold mt-2">Tambah Koleksi Buku</h2>
        <p class="text-muted">Masukkan rincian buku baru untuk ditambahkan ke koleksi.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5">
        <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-12 mb-4">
                    <label class="form-label fw-bold small">Sampul Buku</label>
                    <div class="d-flex align-items-center gap-4">
                        <div id="image-preview" class="border rounded-4 d-flex align-items-center justify-content-center bg-light overflow-hidden shadow-sm" style="width: 140px; height: 180px; min-width: 140px;">
                            <i class="bi bi-image text-muted fs-1 opacity-25"></i>
                        </div>
                        <div class="flex-grow-1">
                            <input type="file" name="foto" id="foto" class="form-control rounded-pill @error('foto') is-invalid @enderror" accept="image/*" onchange="previewImage()">
                            <div class="form-text mt-2">
                                <i class="bi bi-info-circle me-1"></i> Format: JPG, PNG. Ukuran maks 2MB.
                            </div>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold small">Judul Buku</label>
                    <input type="text" name="judul" class="form-control rounded-3 @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Masukkan judul buku" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small">Penulis</label>
                    <input type="text" name="penulis" class="form-control rounded-3 @error('penulis') is-invalid @enderror" value="{{ old('penulis') }}" placeholder="Nama penulis" required>
                    @error('penulis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small">Penerbit</label>
                    <input type="text" name="penerbit" class="form-control rounded-3 @error('penerbit') is-invalid @enderror" value="{{ old('penerbit') }}" placeholder="Nama penerbit" required>
                    @error('penerbit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control rounded-3 @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit') }}" placeholder="Contoh: 2024" required>
                    @error('tahun_terbit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small">Stok</label>
                    <input type="number" name="stok" class="form-control rounded-3 @error('stok') is-invalid @enderror" value="{{ old('stok') }}" placeholder="Jumlah ketersediaan" required min="0">
                    @error('stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="my-4 opacity-10">

            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 flex-grow-1" style="background: #0e9a7e; border: none;">
                    <i class="bi bi-save me-2"></i> Simpan Koleksi
                </button>
                <a href="{{ route('admin.buku.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage() {
        const image = document.querySelector('#foto');
        const imgPreview = document.querySelector('#image-preview');
        
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.innerHTML = `<img src="${oFREvent.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
        }
    }
</script>
@endsection
