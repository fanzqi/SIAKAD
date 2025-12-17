<?php
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Akademik\SemesterController;
use App\Http\Controllers\Akademik\InputNilaiController;
use App\Http\Controllers\Akademik\RuangController;
use App\Http\Controllers\Akademik\MatakuliahController;
use App\Http\Controllers\Akademik\JadwalkuliahController;
use App\Http\Controllers\SmartJadwalController;
use App\Http\Controllers\Akademik\JadwalPdfController;
 use App\Http\Controllers\Akademik\DashboardController;

Route::middleware('auth')->prefix('akademik')->group(function () {

    // Dashboard

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('akademik.dashboard');

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
    // mata Kuliah
    // ===============================
    Route::get('/matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah.index');
    Route::get('/matakuliah/create', [MatakuliahController::class, 'create'])->name('matakuliah.create');
    Route::post('/matakuliah', [MatakuliahController::class, 'store'])->name('matakuliah.store');
    Route::get('/matakuliah/{id}/edit', [MatakuliahController::class, 'edit'])->name('matakuliah.edit');
    Route::put('/matakuliah/{id}', [MatakuliahController::class, 'update'])->name('matakuliah.update');
    Route::delete('/matakuliah/{id}', [MatakuliahController::class, 'destroy'])->name('matakuliah.destroy');


    //ruangan//
    Route::get('/ruang', [RuangController::class, 'index'])->name('ruang.index');
    Route::get('/ruang/create', [RuangController::class, 'create'])->name('ruang.create');
    Route::post('/ruang', [RuangController::class, 'store'])->name('ruang.store');
    Route::get('/ruang/{id}/edit', [RuangController::class, 'edit'])->name('ruang.edit');
    Route::put('/ruang/{id}', [RuangController::class, 'update'])->name('ruang.update');
    Route::delete('/ruang/{id}', [RuangController::class, 'destroy'])->name('ruang.destroy');


    //jadwal kuliah//
    Route::get('/jadwalkuliah', [JadwalkuliahController::class, 'index'])->name('jadwalkuliah.index');
    Route::get('/jadwalkuliah/create', [JadwalkuliahController::class, 'create'])->name('jadwalkuliah.create');
    Route::post('/jadwalkuliah', [JadwalkuliahController::class, 'store'])->name('jadwalkuliah.store');
    Route::get('/jadwalkuliah/{id}/edit', [JadwalkuliahController::class, 'edit'])->name('jadwalkuliah.edit');
    Route::put('/jadwalkuliah/{id}', [JadwalkuliahController::class, 'update'])->name('jadwalkuliah.update');
    Route::delete('/jadwalkuliah/{id}', [JadwalkuliahController::class, 'destroy'])->name('jadwalkuliah.destroy');
    Route::post(
        'matakuliah/generate-jadwal-smart',
        [SmartJadwalController::class, 'generate']
    )->name('generate.jadwal.smart');


    // Hapus Notifikasi
    Route::delete('/notification/{id}', [NotificationController::class, 'destroy'])->name('notification.delete');

    // Import Ruangan
    Route::post('/ruang/index', [RuangController::class, 'import'])->name('ruang.import');
    // Export Jadwal Kuliah excel

    Route::get('jadwalkuliah/export/excel', [JadwalKuliahController::class, 'exportExcel'])
        ->name('jadwalkuliah.export.excel');

    Route::get('/jadwal/pdf-all', [JadwalPdfController::class, 'exportAll'])
        ->name('jadwal.pdf.all');




});
