<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('via.splash'); // Serves resources/views/via/splash.blade.php
});

Route::get('/subscribe', function () {
    return view('via.subscription');
})->name('subscribe');

Route::get('/login', function () {
    return view('via.login');
})->name('login.page');

// ── Public Store ───────────────────────────────────────────────────────
Route::get('/store', [StoreController::class, 'index'])->name('store.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Admin Dashboard Routes ─────────────────────────────────────────────
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
Route::put('/admin/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
Route::post('/admin/subscriptions/{id}', [AdminController::class, 'updateSubscription'])->name('admin.subscriptions.update');

require __DIR__.'/auth.php';
