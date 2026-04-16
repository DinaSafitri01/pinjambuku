<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaControllers;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// --- GUEST / SHARED ROUTES ---
Route::controller(AuthController::class)->group(function() {
    Route::get('/', 'landing')->name('landing');
    Route::get('/select-role', 'welcome')->name('welcome');
    Route::post('/logout', 'logout')->name('logout');

    // Auth Siswa
    Route::get('/login/siswa', 'loginSiswa')->name('login.siswa');
    Route::post('/login/siswa', 'authSiswa')->name('login.siswa.auth');
    Route::get('/register/siswa', 'registerSiswa')->name('register.siswa');
    Route::post('/register/siswa', 'storeSiswa')->name('register.siswa.store');

    // Auth Admin
    Route::get('/login/admin', 'loginAdmin')->name('login.admin');
    Route::post('/login/admin', 'authAdmin')->name('login.admin.auth');
    Route::get('/register/admin', 'registerAdmin')->name('register.admin');
    Route::post('/register/admin', 'storeAdmin')->name('register.admin.store');
});

Route::get('/login', function() {
    return redirect()->route('welcome');
})->name('login');

// --- SISWA ROUTES ---
Route::group(['prefix' => 'siswa', 'as' => 'siswa.', 'middleware' => 'auth'], function() {
    Route::controller(SiswaControllers::class)->group(function() {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/pinjam', 'pinjamIndex')->name('pinjam.index');
        Route::post('/pinjam', 'pinjamStore')->name('pinjam.store');
        Route::get('/riwayat', 'riwayat')->name('riwayat');
        Route::post('/kembali/{peminjaman}', 'kembalikanBuku')->name('kembali');
    });
});

Route::post('/notifications/mark-as-read', [SiswaControllers::class, 'markAsRead'])->middleware('auth')->name('notifications.markAsRead');

// --- ADMIN ROUTES ---
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function() {
    Route::controller(AdminController::class)->group(function() {
        Route::get('/dashboard', 'index')->name('dashboard');

        // Manajemen Anggota
        Route::get('/anggota', 'anggotaIndex')->name('anggota.index');
        Route::get('/anggota/create', 'anggotaCreate')->name('anggota.create');
        Route::post('/anggota', 'anggotaStore')->name('anggota.store');
        Route::get('/anggota/{anggota}/edit', 'anggotaEdit')->name('anggota.edit');
        Route::put('/anggota/{anggota}', 'anggotaUpdate')->name('anggota.update');
        Route::delete('/anggota/{anggota}', 'anggotaDestroy')->name('anggota.destroy');

        // Manajemen Buku
        Route::get('/buku', 'bukuIndex')->name('buku.index');
        Route::get('/buku/create', 'bukuCreate')->name('buku.create');
        Route::post('/buku', 'bukuStore')->name('buku.store');
        Route::get('/buku/{buku}/edit', 'bukuEdit')->name('buku.edit');
        Route::put('/buku/{buku}', 'bukuUpdate')->name('buku.update');
        Route::delete('/buku/{buku}', 'bukuDestroy')->name('buku.destroy');

        // Transaksi
        Route::get('/transaksi', 'transaksiIndex')->name('transaksi.index');
        Route::post('/konfirmasi-kembali/{peminjaman}', 'transaksiConfirm')->name('konfirmasi-kembali');
    });
});
