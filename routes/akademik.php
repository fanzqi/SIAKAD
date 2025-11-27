<?php
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Akademik\SemesterController;
use App\Http\Controllers\Akademik\JadwalkuliahController;
use App\Http\Controllers\Akademik\InputNilaiController;

Route::middleware('auth')->prefix('akademik')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('akademik.dashboard.index');
    })->name('akademik.dashboard');

    // ===============================
    // Semester / Tahun Akademik
    // ===============================
    Route::get('/semester', [SemesterController::class, 'index'])->name('semester.index');
    Route::get('/semester/create', [SemesterController::class, 'create'])->name('semester.create');
    Route::post('/semester', [SemesterController::class, 'store'])->name('semester.store');
    Route::get('/semester/{id}/edit', [SemesterController::class, 'edit'])->name('semester.edit');
    Route::put('/semester/{id}', [SemesterController::class, 'update'])->name('semester.update');
    Route::delete('/semester/{id}', [SemesterController::class, 'destroy'])->name('semester.destroy');

    
Route::get('/input-nilai', [InputNilaiController::class, 'index'])->name('input-nilai.index');
    Route::get('/input-nilai/create', [InputNilaiController::class, 'create'])->name('input-nilai.create');
    Route::post('/input-nilai', [InputNilaiController::class, 'store'])->name('input-nilai.store');
    Route::get('/input-nilai/{id}/edit', [InputNilaiController::class, 'edit'])->name('input-nilai.edit');
    Route::put('/input-nilai/{id}', [InputNilaiController::class, 'update'])->name('input-nilai.update');
    Route::delete('/input-nilai/{id}', [InputNilaiController::class, 'destroy'])->name('input-nilai.destroy');

    // ===============================
    // Jadwal Kuliah
    // ===============================
    Route::get('/jadwalkuliah', [JadwalkuliahController::class, 'index'])->name('jadwalkuliah.index');

    // ===============================
    // Hapus Notifikasi
    // ===============================
    Route::delete('/notification/{id}', [NotificationController::class, 'destroy'])->name('notification.delete');

});
