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
require_once __DIR__ .'/dosen.php';
include 'mahasiswa.php';

// ===============================
// Notifikasi
// ===============================
Route::middleware('auth')->post('/notifications/global', [NotificationController::class, 'createGlobalNotification']);
Route::patch('/akademik/notification/{id}', [NotificationController::class, 'markAsRead']);
Route::delete('/notifikasi/{id}', [NotificationController::class, 'destroy']);
Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead']);
