<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| VIA Onboarding Flow — Route Definitions
|--------------------------------------------------------------------------
|
| Full funnel:
|   1. /          → Splash (brand animation + inline login card)
|   2. /get-started → Standalone email entry (login.blade.php)
|   3. /subscribe  → Subscription selection (subscription.blade.php)
|   4. /create-account → Account creation / register (register.blade.php)
|
*/

// ── 1. Opening screen — brand splash + embedded email card ──
Route::get('/', function () {
    return view('via.splash');
});

// ── 2. Get Started — standalone email entry page ──
Route::get('/get-started', function () {
    return view('via.login');
});

// POST: validate email then redirect to subscription selection
Route::post('/get-started', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    // Store email in session so subsequent steps can pre-fill it
    session(['via_email' => $request->email]);

    return redirect('/subscribe');
});

// ── 3. Subscription selection ──
Route::get('/subscribe', function () {
    return view('via.subscription');
});

// ── 4. Account creation — receives ?plan=basic|core|circle ──
Route::get('/create-account', function () {
    return view('via.register');
});

// POST: handle form submission (placeholder — wire to your auth/user logic)
Route::post('/create-account', function (Request $request) {
    $request->validate([
        'first_name'            => ['required', 'string', 'max:100'],
        'last_name'             => ['required', 'string', 'max:100'],
        'email'                 => ['required', 'email', 'max:255'],
        'password'              => ['required', 'string', 'min:8', 'confirmed'],
        'plan'                  => ['required', 'in:basic,core,circle'],
    ]);

    // TODO: create user record, attach chosen plan, send welcome email
    // For now, redirect to a placeholder dashboard route
    return redirect('/dashboard');
});

// ── 5. Dashboard placeholder (post-registration destination) ──
Route::get('/dashboard', function () {
    return response('VIA Dashboard — coming soon.', 200);
});
