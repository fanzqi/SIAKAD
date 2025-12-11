<?php
use App\Http\Controllers\NotificationController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kaprodi\KurikulumController;


Route::middleware('auth')->prefix('kaprodi')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('kaprodi.dashboard.index');
    })->name('kaprodi.dashboard');

    // ===============================
    // Kurikulum
    // ===============================
    Route::get('/kurikulum', [KurikulumController::class, 'index'])->name('kurikulum.index');
    Route::get('/kurikulum/create', [KurikulumController::class, 'create'])->name('kurikulum.create');
    Route::post('/kurikulum', [KurikulumController::class, 'store'])->name('kurikulum.store');
    Route::get('/kurikulum/{id}/edit', [KurikulumController::class, 'edit'])->name('kurikulum.edit');
    Route::put('/kurikulum/{id}', [KurikulumController::class, 'update'])->name('kurikulum.update');
    Route::delete('/kurikulum/{id}', [KurikulumController::class, 'destroy'])->name('kurikulum.destroy');






});
