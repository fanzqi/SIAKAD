<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dekan\DashboardController;
use App\Http\Controllers\Dekan\JadwalController;



Route::prefix('dekan')->middleware(['auth'])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dekan.dashboard');
    Route::get('dekan/jadwalkuliah', [JadwalController::class, 'index'])
        ->name('dekan/jadwalkuliah');

});