<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kaprodi\KurikulumController;
use App\Http\Controllers\Kaprodi\MatakuliahController;
use App\Http\Controllers\Kaprodi\PlotingdosenController;
use App\Http\Controllers\Kaprodi\DashboardController;
use App\Http\Controllers\Kaprodi\JadwalController;


Route::prefix('kaprodi')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('kaprodi.dashboard');


    // ===============================
    // Kurikulum
    // ===============================
    Route::get('/kurikulum', [KurikulumController::class, 'index'])->name('kurikulum.index');
    Route::get('/kurikulum/create', [KurikulumController::class, 'create'])->name('kurikulum.create');
    Route::post('/kurikulum', [KurikulumController::class, 'store'])->name('kurikulum.store');
    Route::get('/kurikulum/{id}/edit', [KurikulumController::class, 'edit'])->name('kurikulum.edit');
    Route::put('/kurikulum/{id}', [KurikulumController::class, 'update'])->name('kurikulum.update');
    Route::delete('/kurikulum/{id}', [KurikulumController::class, 'destroy'])->name('kurikulum.destroy');



    // ===============================
    // mata Kuliah
    // ===============================
    Route::get('/matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah.index');
    Route::get('/matakuliah/create', [MatakuliahController::class, 'create'])->name('matakuliah.create');
    Route::post('/matakuliah', [MatakuliahController::class, 'store'])->name('matakuliah.store');
    Route::get('/matakuliah/{id}/edit', [MatakuliahController::class, 'edit'])->name('matakuliah.edit');
    Route::put('/matakuliah/{id}', [MatakuliahController::class, 'update'])->name('matakuliah.update');
    Route::delete('/matakuliah/{id}', [MatakuliahController::class, 'destroy'])->name('matakuliah.destroy');

    // ===============================
    // ploting dosen
    // ===============================
    Route::get('/plotingdosen', [PlotingdosenController::class, 'index'])->name('plotingdosen.index');
    Route::get('/plotingdosen/create', [PlotingdosenController::class, 'create'])->name('plotingdosen.create');
    Route::post('/plotingdosen', [PlotingdosenController::class, 'store'])->name('plotingdosen.store');
    Route::get('/plotingdosen/{id}/edit', [PlotingdosenController::class, 'edit'])->name('plotingdosen.edit');
    Route::put('/plotingdosen/{id}', [PlotingdosenController::class, 'update'])->name('plotingdosen.update');
    Route::delete('/plotingdosen/{id}', [PlotingdosenController::class, 'destroy'])->name('plotingdosen.destroy');


   Route::get('/jadwalkuliah', [JadwalController::class, 'index'])
        ->name('kaprodi.jadwalkuliah.index');;
});
