<?php

use App\Http\Controllers\ProfileController;
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
use App\Models\PersonalDetails;

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
Route::resource('carts', CartController::class)->only(['index']);

Route::post('/cart/clear', [CartController::class, 'delete'])->name('carts.clear');//
Route::post('/cart/changequantity', [CartController::class, 'changeQuantity'])->name('carts.changequantity');//
Route::get('/cart/delivery', [CartController::class, 'delivery'])->name('carts.delivery');//

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart/order', [CartController::class, 'order'])->name('carts.order');
});

Route::middleware('auth','ownerOrAdmin')->group(function () {
    Route::get('/cart/order/details/{orderProductId}', [CartController::class, 'details'])->name('carts.order.details');
});

Route::get('/cart/buy', [PersonalDetailsController::class, 'index'])->name('carts.buyWithoutRegistration');///poprawic
Route::post('/cart/changePrice', [CartController::class, 'changePrice'])->name('carts.changePrice');//

Route::post('/cart/storeWithoutRegistration', [PersonalDetailsController::class, 'walidate'])->name('carts.withoutregistration.store');
Route::get('/cart/summary', [CartController::class, 'summary'])->name('carts.summary');
Route::post('/cart/saveWithoutRegistration', [CartController::class, 'saveWithoutRegistration'])->name('carts.savewithoutregistration');

Route::post('/carts/add-promo', [PromoCodeController::class, 'checkPromo'])->name('carts.addPromo');

Route::post('/cart/updateDefaultPersonalDetails', [PersonalDetailsController::class, 'createDefaultPersonalDetails'])->name('carts.updateDefaultPersonalDetails');

Route::resource('contacts', ContactController::class);
Route::post('/contacts/send-mail', [ContactController::class, 'sendMailLetsTalkMail'])->name('contacts.sendMailLetsTalkMail');

Route::resource('AboutUs', AboutUsController::class);

Route::resource('homepage', HomePageController::class);

Route::resource('products', ProductController::class)->only(['index','show','create']);
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('products', ProductController::class)->only(['create','edit','store','destroy','update']);
});

Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('products.comments.store');
});

Route::post('/products/{product}/add_to_cart', [CartController::class, 'addToCart'])->name('products.add_to_cart');
Route::post('/products/{product}/add_to_cart_2', [CartController::class, 'addToCart2'])->name('products.add_to_cart_2');

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
