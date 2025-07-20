<?php
use App\Http\Controllers\GameSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\WorkerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/sessions', [GameSessionController::class, 'index'])->name('sessions.index');
Route::get('/sessions/create', [GameSessionController::class, 'create'])->name('sessions.create');
Route::post('/sessions', [GameSessionController::class, 'store'])->name('sessions.store');
Route::get('/sessions/{session}/dashboard', [GameSessionController::class, 'dashboard'])->name('sessions.dashboard');


// ✅ Dashboard — Single Action Controller
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ✅ Profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Gestion Brands & Workers
Route::middleware(['auth', 'verified'])->group(function () {
    // Brands
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brands.show');
    Route::post('/brands/{brand}/reset-stats', [BrandController::class, 'resetStats'])->name('brands.resetStats');

    // Workers
    Route::get('/workers', [WorkerController::class, 'index'])->name('workers.index');
    Route::get('/workers/{worker}', [WorkerController::class, 'show'])->name('workers.show');
});

require __DIR__.'/auth.php';
