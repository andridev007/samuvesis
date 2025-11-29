<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\JoinController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\JoinConfirmationController;
use App\Http\Controllers\Admin\AdminWithdrawController;

Route::get('/', function () {
    return redirect()->route('member.dashboard');
});

Route::middleware(['auth'])->group(function () {
    // Member
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/join', [JoinController::class, 'index'])->name('join.index');
        Route::post('/join', [JoinController::class, 'store'])->name('join.store');
        Route::get('/join/history', [JoinController::class, 'history'])->name('join.history');
    });

    // Admin (tambahkan middleware role jika sudah setup spatie/permission)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/referral', [SettingController::class, 'saveReferral'])->name('settings.referral.save');
        Route::post('/settings/profit', [SettingController::class, 'saveProfit'])->name('settings.profit.save');
        Route::post('/settings/program', [SettingController::class, 'saveProgram'])->name('settings.program.save');
        Route::post('/settings/join', [SettingController::class, 'saveJoin'])->name('settings.join.save');
        Route::post('/settings/withdraw', [SettingController::class, 'saveWithdraw'])->name('settings.withdraw.save');

        // Join Confirmation
        Route::get('/join-confirmation', [JoinConfirmationController::class, 'index'])->name('join.confirmation.index');
        Route::post('/join-confirmation/{id}/approve', [JoinConfirmationController::class, 'approve'])->name('join.confirmation.approve');
        Route::post('/join-confirmation/{id}/reject', [JoinConfirmationController::class, 'reject'])->name('join.confirmation.reject');

        // Withdraw
        Route::get('/withdraw/confirmation', [AdminWithdrawController::class, 'confirmation'])->name('withdraw.confirmation');
        Route::post('/withdraw/confirmation/{id}/approve', [AdminWithdrawController::class, 'approve'])->name('withdraw.confirmation.approve');
        Route::post('/withdraw/confirmation/{id}/reject', [AdminWithdrawController::class, 'reject'])->name('withdraw.confirmation.reject');
        Route::get('/withdraw/history', [AdminWithdrawController::class, 'history'])->name('withdraw.history');
    });
});