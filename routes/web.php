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
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index'); // Categories user view
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show'); // Category detail view
    Route::get('/events', [EventController::class, 'index'])->name('events.index'); // Events user view
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show'); // Event detail view
});

// ===============================
// ADMIN ONLY — FULL CRUD CATEGORIES + EVENTS
// ===============================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('events', EventController::class);
});

require __DIR__ . '/auth.php';
