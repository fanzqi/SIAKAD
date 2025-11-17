<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Akademik\DashboardController;
use App\Http\Controllers\Akademik\SemesterController;
use App\Http\Controllers\Akademik\JadwalkuliahController;


// ===============================
// Halaman Welcome
// ===============================
Route::get('/', function () {
    return view('welcome');
});


// ===============================
// Autentikasi
// ===============================

// Halaman login
Route::get('/login', [AuthController::class, 'login'])->name('login');

// Proses login
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ===============================
// Protected Routes (Wajib Login)
// ===============================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/akademik/dashboard', function () {
        return view('Dashboard.Dashboard');
    })->name('dashboard');

    // Semester
    Route::get('/akademik/semester', [SemesterController::class, 'index'])->name('semester.semester');

    Route::post('/akademik/semester', [SemesterController::class, 'store'])->name('semester.store');
    Route::get('/akademik/semester/create', [SemesterController::class, 'create'])->name('semester.create');
    // Route::get('/akademik/semester/{id}/edit', [SemesterController::class, 'edit'])->name('semester.edit');
    // Route::put('/akademik/semester/{id}', [SemesterController::class,'update'])->name('semester.update');
    Route::delete('/akademik/semester/{id}', [SemesterController::class, 'destroy'])->name('semester.destroy');
    Route::delete('/notification/{id}', function ($id) {
        \App\Models\Notification::where('id', $id)->delete();
        return response()->json(['success' => true]);
    })->name('notification.delete');


    // Jadwal Kuliah
    Route::get('/akademik/jadwalkuliah', [JadwalkuliahController::class, 'index'])->name('jadwalkuliah');

});
