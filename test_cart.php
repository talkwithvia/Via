<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/cart/add/1', 'POST');
// Disable CSRF for this test by not using the middleware, or we can just run the controller method directly.

$controller = new App\Http\Controllers\CartController();
// Just calling it directly fails because there's no session bound
