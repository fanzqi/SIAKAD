<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dekan\DashboardController;


Route::prefix('dekan')->middleware(['auth'])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dekan.dashboard');

});