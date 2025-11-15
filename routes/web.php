<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'home']);
Route::get('/car-detail/{car}', [CarController::class, 'show']);

// grup route untuk yang belum login
Route::middleware('is_guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register', [AuthController::class, 'storeRegister']);
});

// grup route untuk yang sudah login
Route::middleware('auth')->group(function () {
    // route untuk admin
    Route::middleware('is_admin')->group(function () {
        Route::get('/admin/general-report', [AdminController::class, 'generalReport']);
        Route::post('/admin/confirm-rental/{id}', [AdminController::class, 'confirmRental']);

        Route::get('/admin/car-list', [CarController::class, 'index']);
        Route::get('/admin/add-new-car', [CarController::class, 'create']);
        Route::post('/admin/add-new-car', [CarController::class, 'store']);
        Route::get('/admin/edit-car/{car}', [CarController::class, 'edit']);
        Route::post('/admin/edit-car/{car}', [CarController::class, 'update']);
        Route::delete('/admin/delete-car/{car}', [CarController::class, 'destroy']);
    });

    // route untuk user
    Route::middleware('is_user')->group(function () {
        Route::get('/user/history', [UserController::class, 'history']);
        Route::get('/user/profile', [UserController::class, 'profile']);
        Route::put('/user/profile', [UserController::class, 'updateProfile']);
        Route::put('/user/change-password', [UserController::class, 'changePassword']);
        Route::get('/order/{car}', [UserController::class, 'order']);
        Route::post('/order/{car}', [UserController::class, 'storeOrder']);
        Route::put('/user/rental/{rental}/pay', [UserController::class, 'payRental']);
        Route::delete('/user/rental/{rental}/cancel', [UserController::class, 'cancelRental']);
        Route::get('/user/rental/{rental}/download-receipt', [UserController::class, 'downloadReceipt']);
    });

    // logout route
    Route::get('/logout', [AuthController::class, 'logout']);
});
