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
Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
Route::post('/admin/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
Route::delete('/admin/products/{id}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
Route::post('/admin/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
Route::delete('/admin/categories/{id}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
Route::post('/admin/subscriptions/{id}', [AdminController::class, 'updateSubscription'])->name('admin.subscriptions.update');

require __DIR__.'/auth.php';
