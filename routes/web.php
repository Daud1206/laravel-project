<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// REGISTER
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// ===============================
// USER VIEW — CATEGORIES & EVENTS
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/categories', [CategoryController::class, 'userIndex'])->name('categories.index');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
});

// ===============================
// ADMIN ONLY — FULL CRUD CATEGORIES + EVENTS
// ===============================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('events', [EventController::class, 'index'])->name('admin.events.index');  // Menambahkan route untuk admin events index
    Route::resource('events', EventController::class)->except(['index']); // Menjaga route lainnya
    Route::resource('categories', CategoryController::class);
});

require __DIR__ . '/auth.php';
