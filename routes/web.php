<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('error')->name('error.')->group(function () {
    Route::get('/{code}', function ($code) {
        abort($code);
    })->where('code', '401|403|404|419|429|500|503');
});
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return redirect()->route('admin.dashboard')->with('success', 'Cache cleared successfully.');
});

Auth::routes(['verify' => true]);
// third paty authentications with laravel socialite
Route::get('/auth/{provider}/redirect', [ProviderController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback'])->name('auth.callback');
Route::get('/', function () {
    return view('via.splash'); // Serves resources/views/via/splash.blade.php
});


// ── Public Store ───────────────────────────────────────────────────────
Route::get('/store', [StoreController::class, 'index'])->name('store.index');

Route::prefix('profile')->name('profile.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::put('/update', [ProfileController::class, 'update'])->name('update');
});
// ── Admin Dashboard Routes ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    });
    // activity logs
    Route::resource('activity-log', ActivityLogController::class);
    Route::get('/activity-logs/export', [ActivityLogController::class, 'export'])->name('activity-log.export');
    Route::resource('activity-log', ActivityLogController::class);
    Route::get('/activity-logs/export', [ActivityLogController::class, 'export'])->name('activity-log.export');
    // users
    Route::resource('users', UserController::class);
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    // roles $ permissions
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::get('/roles/{role}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
    Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

    // products and categories management
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::post('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::post('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
    Route::post('/subscriptions/{id}', [AdminController::class, 'updateSubscription'])->name('subscriptions.update');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
