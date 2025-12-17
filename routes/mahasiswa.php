<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mahasiswa\DashboardController;
use App\Http\Controllers\Mahasiswa\JadwalController;

// Semua route WAREK I pakai prefix /warek1 dan harus login
Route::prefix('mahasiswa')->middleware(['auth'])->group(function () {

    // Dashboard WAREK I
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('mahasiswa.dashboard');

   Route::get('/jadwalkuliah', [\App\Http\Controllers\Mahasiswa\JadwalController::class, 'index'])
        ->name('mahasiswa.jadwalkuliah');

});
