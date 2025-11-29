<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\JoinController;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::get('/', function () {
    return redirect()->route('member.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/join', [JoinController::class, 'index'])->name('join.index');
        Route::post('/join', [JoinController::class, 'store'])->name('join.store');
        Route::get('/join/history', [JoinController::class, 'history'])->name('join.history');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });
});