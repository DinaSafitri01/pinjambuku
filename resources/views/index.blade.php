@extends('layouts.app')
@section('title','PINAKU')

@section('content')
<div class="container-fluid vh-100 d-flex">

    <div class="left-box d-flex flex-column justify-content-center p-5">
        <h4>Selamat Datang Di Pinaku</h4>
        <p class="text-muted">Sistem Peminjaman Buku Online</p>

        <p class="mt-4">Silahkan pilih role Anda</p>

        <a href="{{ route('login.siswa') }}" class="role-btn mb-3">
            <i class="bi bi-mortarboard-fill text-primary"></i> SISWA <br>
            <small class="opacity-75">Masuk sebagai siswa untuk meminjam buku</small>
        </a>

        <a href="{{ route('login.admin') }}" class="role-btn">
            <i class="bi bi-people-fill text-success"></i> ADMIN <br>
            <small class="opacity-75">Masuk sebagai admin atau guru</small>
        </a>
    </div>

    <div class="right-box">
        <img src="{{ asset('image/welcome.png') }}" alt="">
    </div>

</div>
@endsection
