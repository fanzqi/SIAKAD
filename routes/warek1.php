<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Warek1\DashboardController;


Route::prefix('warek1')->middleware(['auth'])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('warek1.dashboard');

});
