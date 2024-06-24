<?php

use App\Controllers\AuthenticationsController;
use App\Controllers\ProfileController;
use App\Controllers\DemandController;
use Core\Router\Route;

// Authentication
Route::get('/login', [AuthenticationsController::class, 'new'])->name('users.login');
Route::post('/login', [AuthenticationsController::class, 'authenticate'])->name('users.authenticate');

Route::middleware('auth')->group(function () {

    Route::get('/', [DemandController::class, 'index'])->name('root');

    Route::get('/demands', [DemandController::class, 'index'])->name('demands.index');

    Route::get('/demands/create', [DemandController::class, 'create'])->name('demands.create');

    Route::get('/logout', [AuthenticationsController::class, 'destroy'])->name('users.logout');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    // Users


    // Demands

});
