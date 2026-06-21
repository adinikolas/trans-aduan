<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplaintController;
use Illuminate\Support\Facades\Route;

// 1. HALAMAN AWAL (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// 2. REDIRECT SETELAH LOGIN
// Breeze otomatis mengarahkan user ke '/dashboard' setelah login.
// Kita cegat rute ini, dan langsung kita lempar ke '/aduan'.
// Logika pembagian layarnya akan diurus oleh ComplaintController@index.
Route::get('/dashboard', function () {
    return redirect()->route('complaints.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. RUTE SISTEM ADUAN (Modul Utama)
Route::middleware('auth')->group(function () {
    Route::get('/aduan', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/aduan/buat', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/aduan', [ComplaintController::class, 'store'])->name('complaints.store');
    
    // Rute Detail & Update
    Route::get('/aduan/{id}', [ComplaintController::class, 'show'])->name('complaints.show');   
    Route::put('/aduan/{id}', [ComplaintController::class, 'update'])->name('complaints.update');

    // Rute Tindak Lanjut Kadiv
    Route::get('/aduan/{id}/tindak-lanjut', [ComplaintController::class, 'resolve'])->name('complaints.resolve');
    Route::put('/aduan/{id}/tindak-lanjut', [ComplaintController::class, 'storeResolution'])->name('complaints.store_resolution');

    // Rute Ulasan
    Route::get('/aduan/{id}/ulasan', [ComplaintController::class, 'feedback'])->name('complaints.feedback');
    Route::post('/aduan/{id}/ulasan', [ComplaintController::class, 'storeFeedback'])->name('complaints.store_feedback');
});

// 4. RUTE PROFIL BAWAAN BREEZE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';