<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\HomePageController;

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

Route::resource('contacts', ContactController::class);

Route::resource('AboutUs', AboutUsController::class);

Route::resource('products', ProductController::class);
Route::resource('homepage', HomePageController::class);

// Route::get('products', [ProductController::class, 'category_products'])->name('products.category_products');;
Route::post('/products/{product}/comments', [ProductController::class, 'storeComment'])->name('products.comments.store');
Route::post('/products/{product}/add_to_cart', [ProductController::class, 'addToCart'])->name('products.add_to_cart');

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
