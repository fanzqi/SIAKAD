<?php
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dosen\DashboardController;
use App\Http\Controllers\Dosen\NilaiMahasiswaController;
use App\Http\Controllers\Dosen\JadwalController;


Route::middleware('auth')->prefix('dosen')->group(function () {

    // Dashboard

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dosen.dashboard');
    // ===============================
    //  nilai mahasiswa
    // ===============================
    Route::get('/inputnilaimahasiswa', [NilaiMahasiswaController::class, 'index'])
        ->name('inputnilaimahasiswa.index');

    // Form tambah nilai mahasiswa
    Route::get('/inputnilaimahasiswa/create', [NilaiMahasiswaController::class, 'create'])
        ->name('inputnilaimahasiswa.create');

    // Simpan data nilai mahasiswa
    Route::post('/inputnilaimahasiswa', [NilaiMahasiswaController::class, 'store'])
        ->name('inputnilaimahasiswa.store');

    // Form edit nilai mahasiswa
    Route::get('/inputnilaimahasiswa/{id}/edit', [NilaiMahasiswaController::class, 'edit'])
        ->name('inputnilaimahasiswa.edit');

    // Update data nilai mahasiswa
    Route::put('/inputnilaimahasiswa/{id}', [NilaiMahasiswaController::class, 'update'])
        ->name('inputnilaimahasiswa.update');

    Route::get('jadwalkuliah', [JadwalController::class, 'index'])
        ->name('dosen.jadwalkuliah');

    Route::post('/nilai/import', [NilaiMahasiswaController::class, 'import'])->name('nilai.import');

    // Hapus Notifikasi
    Route::delete('/notification/{id}', [NotificationController::class, 'destroy'])->name('notification.delete');






});
