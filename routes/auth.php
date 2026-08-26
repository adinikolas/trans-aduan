<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// ============================================================
// GUEST
// ============================================================

Route::middleware('guest')->group(function () {

    // --------------------------------------------------------
    // REGISTRASI PENGGUNA
    // --------------------------------------------------------

    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])
        ->name('register.store');

    // --------------------------------------------------------
    // LOGIN PENGGUNA UMUM
    // --------------------------------------------------------

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // --------------------------------------------------------
    // LOGIN INTERNAL
    // --------------------------------------------------------

    Route::get('internal/login', [AuthenticatedSessionController::class, 'createInternal'])
        ->name('internal.login');

    Route::post('internal/login', [AuthenticatedSessionController::class, 'storeInternal'])
        ->name('internal.login.store');

    // --------------------------------------------------------
    // LUPA PASSWORD
    // --------------------------------------------------------

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // --------------------------------------------------------
    // RESET PASSWORD
    // --------------------------------------------------------

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// ============================================================
// AUTHENTICATED USER
// ============================================================

Route::middleware('auth')->group(function () {

    // --------------------------------------------------------
    // CONFIRM PASSWORD
    // --------------------------------------------------------

    Route::get('confirm-password', [
        ConfirmablePasswordController::class,
        'show',
    ])->name('password.confirm');

    Route::post('confirm-password', [
        ConfirmablePasswordController::class,
        'store',
    ]);

    // --------------------------------------------------------
    // UPDATE PASSWORD
    // --------------------------------------------------------

    Route::put('password', [
        PasswordController::class,
        'update',
    ])->name('password.update');

    // --------------------------------------------------------
    // LOGOUT
    // --------------------------------------------------------

    Route::post('logout', [
        AuthenticatedSessionController::class,
        'destroy',
    ])->name('logout');
});
