<?php

use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\StatuteController;
use App\Http\Controllers\PersonalDetailsController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\OrdersController;

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

Route::resource('cart', CartController::class)->only(['create', 'destroy']);

Route::post('/cart/clear', [CartController::class, 'destroyAll'])->name('carts.clear'); //
Route::post('/cart/updateQuantity', [CartController::class, 'updateQuantity'])->name('carts.updateQuantity'); //
Route::get('/order/create', [OrdersController::class, 'create'])->name('orders.create'); //

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/order', [OrdersController::class, 'index'])->name('orders.index');
});

Route::middleware('auth', 'ownerOrAdmin')->group(function () {
    Route::get('/order/{orderProductId}', [OrdersController::class, 'show'])->name('orders.show');
});

Route::get('/personalDetails/create', [PersonalDetailsController::class, 'create'])->name('personalDetails.create');
Route::post('/cart/updatePrice', [CartController::class, 'updatePrice'])->name('carts.updatePrice'); //

Route::post('/personalDetail/walidation', [PersonalDetailsController::class, 'walidate'])->name('personalDetails.walidate');
Route::get('/cart/show', [CartController::class, 'show'])->name('carts.show');
Route::post('/order/store', [OrdersController::class, 'store'])->name('orders.store');

Route::post('/promoCode/checkPromo', [PromoCodeController::class, 'checkPromo'])->name('promoCodes.checkPromo');

Route::post('/personalDetail/store', [PersonalDetailsController::class, 'store'])->name('personalDetails.store');

Route::resource('contacts', ContactController::class);
Route::post('/contacts/sendMail', [ContactController::class, 'sendMail'])->name('contacts.sendMail');

Route::resource('aboutUs', AboutUsController::class); //

Route::resource('homepage', HomePageController::class);

Route::resource('products', ProductController::class)->only(['index', 'show', 'create']);
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('products', ProductController::class)->only(['create', 'edit', 'store', 'destroy', 'update']);
});

Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('products.comments.store');
});

Route::post('/products/{product}/addToCart', [CartController::class, 'storeAndRedirect'])->name('carts.addToCart');
Route::post('/products/{product}/addToCart2', [CartController::class, 'store'])->name('carts.addToCart2');

Route::post('/subscriber/store', [SubscriberController::class, 'store'])->name('subscribers.store');

Route::resource('statutes', StatuteController::class)->except(['show']);
Route::get('/statutes', [StatuteController::class, 'show'])->name('statutes.show');


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

Route::get('/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

require __DIR__ . '/auth.php';
