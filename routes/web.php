<?php

use App\Models\News;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

// ============================================================
// LANDING PAGE
// ============================================================

Route::get('/', function () {
    $news = News::where('status', 'published')
        ->whereNotNull('published_at')
        ->orderByDesc('published_at')
        ->take(6)
        ->get();

    return view('welcome', compact('news'));
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

    // Rekap Ulasan Pengguna - Internal
    Route::get('/ulasan-pengguna', [ComplaintController::class, 'indexFeedback'])
        ->name('feedback.index');

    // Report / Export Excel
    Route::get('/laporan', [ExportController::class, 'index'])
        ->name('reports.index');

    Route::get('/laporan/export', [ExportController::class, 'export'])
        ->name('reports.export');

    // ========================================================
    // BERITA - CC ROOM
    // ========================================================

    Route::prefix('cc-room/berita')->name('news.')->group(function () {

        Route::get('/', [NewsController::class, 'index'])
            ->name('index');

        Route::get('/buat', [NewsController::class, 'create'])
            ->name('create');

        Route::post('/', [NewsController::class, 'store'])
            ->name('store');

        Route::get('/{news}/edit', [NewsController::class, 'edit'])
            ->name('edit');

        Route::put('/{news}', [NewsController::class, 'update'])
            ->name('update');

        Route::delete('/{news}', [NewsController::class, 'destroy'])
            ->name('destroy');
    });

    // ========================================================
    // MASTER KATEGORI - CC ROOM
    // ========================================================

    Route::prefix('cc-room/kategori')
        ->name('categories.')
        ->controller(CategoryController::class)
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/buat', 'create')
                ->name('create');

            Route::post('/', 'store')
                ->name('store');

            Route::get('/{category}/edit', 'edit')
                ->name('edit');

            Route::put('/{category}', 'update')
                ->name('update');

            Route::patch('/{category}/status', 'toggleStatus')
                ->name('toggle-status');
        });

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
