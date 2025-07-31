<?php

use App\Http\Controllers\{
    BrandController,
    ContractController,
    DashboardController,
    DraftController,
    GameSessionController,
    ProfileController,
    WorkerController
};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//  Page publique
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

//  Routes protégées
Route::middleware(['auth', 'verified'])->group(function () {
    //  Game Sessions
    Route::get('/sessions',                        [GameSessionController::class, 'index'])->name('sessions.index');
    Route::get('/sessions/create',                 [GameSessionController::class, 'create'])->name('sessions.create');
    Route::post('/sessions',                       [GameSessionController::class, 'store'])->name('sessions.store');
    Route::get('/sessions/{session}/dashboard',    [GameSessionController::class, 'dashboard'])->name('sessions.dashboard');

    //  Draft
    Route::get('/sessions/{session}/draft',        [DraftController::class, 'show'])->name('sessions.draft');
    Route::post('/sessions/{session}/draft/pick',  [DraftController::class, 'pick'])->name('sessions.draft.pick');
    Route::post('/sessions/{session}/draft/next',  [DraftController::class, 'nextStep'])->name('sessions.draft.next');

    //  Redirection ancienne URL
    Route::redirect('/dashboard', '/sessions');

    //  Dashboard
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    //  Profil utilisateur
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //  Brands
    Route::get('/brands',                     [BrandController::class,  'index'])->name('brands.index');
    Route::get('/brands/{brand}',             [BrandController::class,  'show'])->name('brands.show');
    Route::post('/brands/{brand}/reset-stats',[BrandController::class,  'resetStats'])->name('brands.resetStats');

    //  Contracts
    Route::get('/contracts',                  [ContractController::class, 'index'])->name('contracts.index');

    // Workers
    Route::get('/workers',                    [WorkerController::class, 'index'])->name('workers.index');
    Route::get('/workers/{worker}',           [WorkerController::class, 'show'])->name('workers.show');
});

require __DIR__.'/auth.php';
