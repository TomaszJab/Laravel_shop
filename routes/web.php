<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

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
Route::resource('carts', CartController::class);
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('carts.clear');
Route::resource('products', ProductController::class);
Route::post('/products/{product}/comments', [ProductController::class, 'storeComment'])->name('products.comments.store');
Route::post('/products/{product}/add_to_cart', [ProductController::class, 'addToCart'])->name('products.add_to_cart');

Route::get('/', function () {
    return view('welcome');
});
