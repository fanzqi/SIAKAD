<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Warek1\DashboardController;
use App\Http\Controllers\Warek1\WarekJadwalController;

Route::prefix('warek1')->middleware(['auth'])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('warek1.dashboard');


    Route::get('/jadwal', [WarekJadwalController::class, 'index'])
        ->name('warek1.jadwal.index');

    // setujui jadwal
    Route::post('/jadwal/{id}/setujui', [WarekJadwalController::class, 'setujui'])
        ->name('warek1.jadwal.setujui');

    // revisi jadwal
    Route::post('/jadwal/{id}/revisi', [WarekJadwalController::class, 'revisi'])
        ->name('warek1.jadwal.revisi');

    // ACC satu jadwal (POST lebih aman)
    Route::post('/warek1/jadwal/{id}/setujui', [WarekJadwalController::class, 'setujui'])->name('warek1.jadwal.setujui');

    // ACC bulk
    Route::post('/warek1/jadwal/setujui-bulk', [WarekJadwalController::class, 'setujuiBulk'])->name('warek1.jadwal.setujuiBulk')->middleware('auth');

    // ACC semua
    Route::post('/warek1/jadwal/setujui-semua', [WarekJadwalController::class, 'setujuiSemua'])->name('warek1.jadwal.setujuiSemua');

    // Kembalikan ke revisi
    Route::post('/warek1/jadwal/revisi/{id}', [WarekJadwalController::class, 'revisi'])->name('warek1.jadwal.revisi');
});