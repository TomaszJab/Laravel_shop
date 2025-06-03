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
Route::resource('cart', CartController::class)->only(['create']);

Route::post('/cart/clear', [CartController::class, 'destroyAll'])->name('carts.clear');//
Route::post('/cart/changequantity', [CartController::class, 'updateQuantity'])->name('carts.changequantity');//
Route::get('/cart/delivery', [OrdersController::class, 'create'])->name('carts.delivery');//

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/order', [OrdersController::class, 'index'])->name('carts.order');
});

Route::middleware('auth','ownerOrAdmin')->group(function () {
    Route::get('/order/details/{orderProductId}', [OrdersController::class, 'show'])->name('carts.order.details');
});

Route::get('/cart/buy', [PersonalDetailsController::class, 'show'])->name('carts.buyWithoutRegistration');///poprawic
Route::post('/cart/changePrice', [CartController::class, 'updatePrice'])->name('carts.changePrice');//

Route::post('/cart/storeWithoutRegistration', [PersonalDetailsController::class, 'walidate'])->name('carts.withoutregistration.store');
Route::get('/cart/summary', [CartController::class, 'show'])->name('carts.summary');
Route::post('/cart/saveWithoutRegistration', [OrdersController::class, 'store'])->name('carts.savewithoutregistration');

Route::post('/carts/add-promo', [PromoCodeController::class, 'checkPromo'])->name('carts.addPromo');

Route::post('/cart/updateDefaultPersonalDetails', [PersonalDetailsController::class, 'store'])->name('carts.updateDefaultPersonalDetails');

Route::resource('contacts', ContactController::class);
Route::post('/contacts/send-mail', [ContactController::class, 'sendMail'])->name('contacts.sendMailLetsTalkMail');

Route::resource('AboutUs', AboutUsController::class);

Route::resource('homepage', HomePageController::class);

Route::resource('products', ProductController::class)->only(['index','show','create']);
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('products', ProductController::class)->only(['create','edit','store','destroy','update']);
});

Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('products.comments.store');
});

Route::post('/products/{product}/addToCart', [CartController::class, 'storeAndRedirect'])->name('products.addToCart');
Route::post('/products/{product}/addToCart2', [CartController::class, 'store'])->name('products.addToCart2');

Route::post('/products/subscribe', [SubscriberController::class, 'store'])->name('products.subscribe');

Route::resource('statutes', StatuteController::class);

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

require __DIR__.'/auth.php';
