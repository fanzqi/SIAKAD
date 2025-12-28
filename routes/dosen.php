<?php
file_put_contents(base_path('dosen_debug.txt'), __FILE__ . PHP_EOL, FILE_APPEND);
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dosen\DashboardController;
use App\Http\Controllers\Dosen\NilaiMahasiswaController;
use App\Http\Controllers\Dosen\JadwalController;
use App\Http\Controllers\TranskripController;

// Dashboard, Jadwal, dsb TANPA cek.periode.inputnilai
Route::middleware(['auth'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dosen.dashboard');

    // Jadwal
    Route::get('/jadwalkuliah', [JadwalController::class, 'index'])->name('dosen.jadwalkuliah');

    // Hapus Notifikasi
    Route::delete('/notification/{id}', [NotificationController::class, 'destroy'])->name('notification.delete');

    // Transkrip Mahasiswa
    Route::get('/transkrip-mahasiswa/{id}', [TranskripController::class, 'show'])->name('transkrip.mahasiswa');


    Route::get('inputnilaimahasiswa', [NilaiMahasiswaController::class, 'index'])->name('inputnilaimahasiswa.index');
    Route::put('inputnilaimahasiswa/{mahasiswa_id}', [NilaiMahasiswaController::class, 'update'])->name('inputnilaimahasiswa.update');
    Route::get('/inputnilaimahasiswa/create', [NilaiMahasiswaController::class, 'create'])->name('inputnilaimahasiswa.create');
    Route::post('/inputnilaimahasiswa', [NilaiMahasiswaController::class, 'store'])->name('inputnilaimahasiswa.store');
    Route::get('/inputnilaimahasiswa/{id}/edit', [NilaiMahasiswaController::class, 'edit'])->name('inputnilaimahasiswa.edit');
    Route::post('/nilai/import', [NilaiMahasiswaController::class, 'import'])->name('nilai.import');


    Route::get('/get-mahasiswa-by-matkul/{mata_kuliah_id}', [NilaiMahasiswaController::class, 'getMahasiswaByMatkul'])->name('get.mahasiswa.by.matkul');
});