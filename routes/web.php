<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Akademik\DashboardController;
use App\Http\Controllers\Akademik\SemesterController;
use App\Http\Controllers\Akademik\JadwalkuliahController;

// ===============================
// Redirect root to login
// ===============================
Route::redirect('/', '/login');

// ===============================
// Autentikasi
// ===============================

// Halaman login
Route::get('/login', [AuthController::class, 'login'])->name('login');

// Proses login
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

include 'akademik.php';
include 'warek1.php';
include 'dekan.php';
include 'kaprodi.php';
include 'dosen.php';
include 'mahasiswa.php';

// ===============================
// Notifikasi
// ===============================

// Tandai notifikasi sebagai sudah dibaca (POST/PATCH, pilih salah satu, biasanya PATCH)
Route::patch('/akademik/notification/{id}/read', [NotificationController::class, 'markAsRead'])
    ->name('notification.read')
    ->middleware('auth');

// Hapus notifikasi (gunakan satu endpoint saja, konsisten)
Route::delete('/akademik/notification/{id}', [NotificationController::class, 'destroy'])
    ->name('notification.delete')
    ->middleware('auth');