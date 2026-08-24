<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplaintController;
use Illuminate\Support\Facades\Route;

// 1. HALAMAN AWAL (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// 2. REDIRECT SETELAH LOGIN
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'manager_keuangan' => redirect()->route('manager.keuangan'),
        'manager_operasional' => redirect()->route('manager.operasional'),
        default => redirect()->route('complaints.index'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. RUTE SISTEM ADUAN
Route::middleware('auth')->group(function () {
    Route::get('/aduan', [ComplaintController::class, 'index'])
        ->name('complaints.index');

    // Dashboard Manager
    Route::get('/manager/keuangan', [ComplaintController::class, 'dashboardManagerKeuangan'])
        ->name('manager.keuangan');

    Route::get('/manager/operasional', [ComplaintController::class, 'dashboardManagerOperasional'])
        ->name('manager.operasional');

    // Daftar Aduan Manager
    Route::get('/manager/keuangan/aduan', [ComplaintController::class, 'aduanManagerKeuangan'])
        ->name('manager.keuangan.aduan');

    Route::get('/manager/operasional/aduan', [ComplaintController::class, 'aduanManagerOperasional'])
        ->name('manager.operasional.aduan');

    Route::get('/aduan/buat', [ComplaintController::class, 'create'])
        ->name('complaints.create');

    Route::post('/aduan', [ComplaintController::class, 'store'])
        ->name('complaints.store');

    // Detail & Update
    Route::get('/aduan/{id}', [ComplaintController::class, 'show'])
        ->name('complaints.show');

    Route::put('/aduan/{id}', [ComplaintController::class, 'update'])
        ->name('complaints.update');

    // Tindak Lanjut Manager
    Route::get('/aduan/{id}/tindak-lanjut', [ComplaintController::class, 'resolve'])
        ->name('complaints.resolve');

    Route::put('/complaints/{id}/store-resolve', [ComplaintController::class, 'store_resolve'])
        ->name('complaints.store_resolve');

    Route::put('/aduan/{id}/tindak-lanjut', [ComplaintController::class, 'storeResolution'])
        ->name('complaints.store_resolution');

    // Ulasan
    Route::get('/aduan/{id}/ulasan', [ComplaintController::class, 'feedback'])
        ->name('complaints.feedback');

    Route::post('/aduan/{id}/ulasan', [ComplaintController::class, 'storeFeedback'])
        ->name('complaints.store_feedback');
});

// 4. RUTE PROFIL BAWAAN BREEZE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
