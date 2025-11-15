<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Route yang bisa diakses oleh semua orang (guest & authenticated)
 */
Route::get('/', [AuthController::class, 'home']); // Halaman utama/landing page
Route::get('/car-detail/{car}', [CarController::class, 'show']); // Detail mobil

/**
 * Grup route untuk yang BELUM login (guest only)
 * Jika sudah login, akan otomatis di-redirect
 */
Route::middleware('is_guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login'); // Form login
    Route::post('/login', [AuthController::class, 'authenticate']); // Proses login
    Route::get('/register', [AuthController::class, 'register']); // Form registrasi
    Route::post('/register', [AuthController::class, 'storeRegister']); // Proses registrasi
});

/**
 * Grup route untuk yang SUDAH login (authenticated users)
 * Dibagi menjadi 2 sub-grup: admin dan user
 */
Route::middleware('auth')->group(function () {

    /**
     * Route khusus ADMIN
     * Hanya bisa diakses oleh user dengan role 'admin'
     */
    Route::middleware('is_admin')->group(function () {
        Route::get('/admin/general-report', [AdminController::class, 'generalReport']); // Laporan semua pesanan
        Route::post('/admin/confirm-rental/{id}', [AdminController::class, 'confirmRental']); // Konfirmasi pembayaran

        // CRUD Mobil
        Route::get('/admin/car-list', [CarController::class, 'index']); // Daftar mobil
        Route::get('/admin/add-new-car', [CarController::class, 'create']); // Form tambah mobil
        Route::post('/admin/add-new-car', [CarController::class, 'store']); // Simpan mobil baru
        Route::get('/admin/edit-car/{car}', [CarController::class, 'edit']); // Form edit mobil
        Route::post('/admin/edit-car/{car}', [CarController::class, 'update']); // Update mobil
        Route::delete('/admin/delete-car/{car}', [CarController::class, 'destroy']); // Hapus mobil
    });

    /**
     * Route khusus USER (customer)
     * Hanya bisa diakses oleh user dengan role 'user'
     */
    Route::middleware('is_user')->group(function () {
        // Manajemen Pesanan
        Route::get('/user/history', [UserController::class, 'history']); // Riwayat pesanan
        Route::get('/order/{car}', [UserController::class, 'order']); // Form pemesanan
        Route::post('/order/{car}', [UserController::class, 'storeOrder']); // Simpan pesanan
        Route::put('/user/rental/{rental}/pay', [UserController::class, 'payRental']); // Bayar pesanan
        Route::delete('/user/rental/{rental}/cancel', [UserController::class, 'cancelRental']); // Batalkan pesanan
        Route::get('/user/rental/{rental}/download-receipt', [UserController::class, 'downloadReceipt']); // Download struk PDF

        // Manajemen Profil
        Route::get('/user/profile', [UserController::class, 'profile']); // Halaman profil
        Route::put('/user/profile', [UserController::class, 'updateProfile']); // Update profil
        Route::put('/user/change-password', [UserController::class, 'changePassword']); // Ubah password
    });

    /**
     * Logout route - bisa diakses admin maupun user
     */
    Route::get('/logout', [AuthController::class, 'logout']);
});
