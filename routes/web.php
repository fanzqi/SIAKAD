<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Akademik\DashboardController;
use App\Http\Controllers\Akademik\SemesterController;
use App\Http\Controllers\Akademik\JadwalkuliahController;

use App\Http\Controllers\NotificationController;

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

include 'akademik.php';
include 'warek1.php';
include 'dekan.php';
include 'kaprodi.php';
include 'dosen.php';
include 'mahasiswa.php';

// ===============================
// Notifikasi
// ===============================

Route::post('/akademik/notification/read/{id}', [NotificationController::class, 'markAsRead'])->name('notification.read');
Route::delete('/akademik/notification/{id}', [NotificationController::class, 'destroy'])->name('notification.delete');

// opsional: buat notifikasi global via route (hanya contoh)
Route::get('/akademik/notification/global/create', [NotificationController::class, 'createGlobalNotification']);

Route::patch('/akademik/notification/{id}', [NotificationController::class, 'markAsRead']);Route::patch('/akademik/notification/{id}', [NotificationController::class, 'markAsRead']);
