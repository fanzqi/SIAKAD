<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dosen\DashboardController;


Route::prefix('dosen')->middleware(['auth'])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dosen.dashboard');

});