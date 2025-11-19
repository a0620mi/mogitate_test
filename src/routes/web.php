<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);

// Route::get('/products/{product}', [ProductController::class, 'show']);
// Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
// Route::get('/products/create', [ProductController::class, 'create']);
// Route::get('/products', [ProductController::class, 'index'])->name('products.index');


