<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mahasiswa\DashboardController;
use App\Http\Controllers\Mahasiswa\JadwalController;

Route::prefix('mahasiswa')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('mahasiswa.dashboard');

    Route::get('/jadwalkuliah', [JadwalController::class, 'index'])
        ->name('mahasiswa.jadwalkuliah');

    Route::get('nilai', [\App\Http\Controllers\Mahasiswa\NilaiController::class, 'index'])->name('mahasiswa.nilai.index');
});