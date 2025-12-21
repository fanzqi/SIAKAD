<?php
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Akademik\JadwalkuliahController;
use App\Http\Controllers\SmartJadwalController;
use App\Http\Controllers\Akademik\JadwalPdfController;
use App\Http\Controllers\Dosen\DashboardController;
use App\Http\Controllers\Dosen\NilaiMahasiswaController;

Route::middleware('auth')->prefix('dosen')->group(function () {

    // Dashboard

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dosen.dashboard');
    // ===============================
    //  nilai mahasiswa
    // ===============================
    Route::get('/inputnilaimahasiswa', [NilaiMahasiswaController::class, 'index'])->name('inputnilaimahasiswa.index');
    Route::get('/inputnilaimahasiswa/create', [NilaiMahasiswaController::class, 'create'])->name('inputnilaimahasiswa.create');
    Route::post('/inputnilaimahasiswa', [NilaiMahasiswaController::class, 'store'])->name('inputnilaimahasiswa.store');
    Route::get('/inputnilaimahasiswa/{id}/edit', [NilaiMahasiswaController::class, 'edit'])->name('inputnilaimahasiswa.edit');
    Route::put('/inputnilaimahasiswa/{id}', [NilaiMahasiswaController::class, 'update'])->name('inputnilaimahasiswa.update');
    Route::delete('/inputnilaimahasiswa/{id}', [NilaiMahasiswaController::class, 'destroy'])->name('inputnilaimahasiswa.destroy');


    // Hapus Notifikasi
    Route::delete('/notification/{id}', [NotificationController::class, 'destroy'])->name('notification.delete');

    




});
