<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservasiController;

// Halaman publik (Guest)
Route::get('/', [GuestController::class, 'beranda'])->name('beranda');
Route::get('/ruang', [GuestController::class, 'ruang'])->name('ruang.index');
Route::get('/ruang/{ruang}', [GuestController::class, 'show'])->name('ruang.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Placeholder sementara, nanti diganti ReservasiController
    Route::get('/reservasi', fn () => 'Reservasi Saya (segera)')->name('reservations.index');
    Route::get('/reservasi/buat', [ReservasiController::class, 'create'])->name('reservations.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservations.store');
});