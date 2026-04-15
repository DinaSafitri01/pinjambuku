@extends('layout.dashboard')

@section('content')
<div class="animate__animated animate__fadeIn" style="max-width: 800px;">
    <div class="mb-4">
        <a href="{{ route('admin.anggota.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
        <h2 class="fw-bold mt-2">Tambah Anggota Baru</h2>
        <p class="text-muted">Masukkan informasi lengkap siswa untuk pendaftaran anggota.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5">
        <form action="{{ route('admin.anggota.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small">NIS (Nomor Induk Siswa)</label>
                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" placeholder="Contoh: 212210001" required value="{{ old('nis') }}">
                    @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small">Alamat Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="nama@siswa.com" required value="{{ old('email') }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small">Kelas</label>
                    <select name="kelas" class="form-select" required>
                        <option value="">Pilih Kelas</option>
                        <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>Kelas X</option>
                        <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                        <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small">Jurusan</label>
                    <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" placeholder="Contoh: RPL, TKJ, dll" value="{{ old('jurusan') }}">
                    @error('jurusan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold small">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <hr class="my-4 opacity-10">

            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary rounded-pill px-5 flex-grow-1" style="background: #1976d2; border: none;">
                    Simpan Data Anggota
                </button>
                <a href="{{ route('admin.anggota.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
