<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ============================================================
// LANDING PAGE
// ============================================================

Route::get('/', function () {
    return view('welcome');
});

// ============================================================
// DASHBOARD
// ============================================================

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'manager_keuangan' => redirect()->route('manager.keuangan'),
        'manager_operasional' => redirect()->route('manager.operasional'),
        default => redirect()->route('complaints.index'),
    };
})->middleware('auth')->name('dashboard');

// ============================================================
// SISTEM ADUAN
// ============================================================

Route::middleware('auth')->group(function () {

    // Dashboard / Daftar Aduan
    Route::get('/aduan', [ComplaintController::class, 'index'])
        ->name('complaints.index');

    // Buat Aduan
    Route::get('/aduan/buat', [ComplaintController::class, 'create'])
        ->name('complaints.create');

    Route::post('/aduan', [ComplaintController::class, 'store'])
        ->name('complaints.store');

    // Detail Aduan
    Route::get('/aduan/{id}', [ComplaintController::class, 'show'])
        ->name('complaints.show');

    // Update Aduan - CC Room
    Route::put('/aduan/{id}', [ComplaintController::class, 'update'])
        ->name('complaints.update');

    // Tindak Lanjut Manager
    Route::get('/aduan/{id}/tindak-lanjut', [ComplaintController::class, 'resolve'])
        ->name('complaints.resolve');

    Route::put('/aduan/{id}/tindak-lanjut', [ComplaintController::class, 'storeResolution'])
        ->name('complaints.store_resolution');

    // Legacy route
    Route::put('/complaints/{id}/store-resolve', [ComplaintController::class, 'store_resolve'])
        ->name('complaints.store_resolve');

    // Ulasan
    Route::get('/aduan/{id}/ulasan', [ComplaintController::class, 'feedback'])
        ->name('complaints.feedback');

    Route::post('/aduan/{id}/ulasan', [ComplaintController::class, 'storeFeedback'])
        ->name('complaints.store_feedback');

    // ========================================================
    // MANAGER KEUANGAN
    // ========================================================

    Route::get('/manager/keuangan', [ComplaintController::class, 'dashboardManagerKeuangan'])
        ->name('manager.keuangan');

    Route::get('/manager/keuangan/aduan', [ComplaintController::class, 'aduanManagerKeuangan'])
        ->name('manager.keuangan.aduan');

    Route::get('/manager/keuangan/jenis-aduan', [ComplaintController::class, 'jenisAduanManagerKeuangan'])
        ->name('manager.keuangan.jenis');

    // ========================================================
    // MANAGER OPERASIONAL
    // ========================================================

    Route::get('/manager/operasional', [ComplaintController::class, 'dashboardManagerOperasional'])
        ->name('manager.operasional');

    Route::get('/manager/operasional/aduan', [ComplaintController::class, 'aduanManagerOperasional'])
        ->name('manager.operasional.aduan');

    Route::get('/manager/operasional/jenis-aduan', [ComplaintController::class, 'jenisAduanManagerOperasional'])
        ->name('manager.operasional.jenis');
});

// ============================================================
// PROFILE
// ============================================================

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// ============================================================
// AUTH
// ============================================================

require __DIR__.'/auth.php';
