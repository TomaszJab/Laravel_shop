<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\StatuteController;
use App\Models\promoCode;
use App\Mail\AboutUsLetsTalkMail;

use App\Http\Controllers\GoogleLoginController;
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
Route::post('/cart/changequantity', [CartController::class, 'changequantity'])->name('carts.changequantity');
Route::get('/cart/delivery', [CartController::class, 'delivery'])->name('carts.delivery');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart/order', [CartController::class, 'order'])->name('carts.order');
});

Route::middleware('auth','ownerOrAdmin')->group(function () {
    Route::get('/cart/order/details/{orderProductId}', [CartController::class, 'details'])->name('carts.order.details');
});

Route::get('/cart/buy', [CartController::class, 'buyWithoutRegistration'])->name('carts.buyWithoutRegistration');
Route::post('/cart/changePrice', [CartController::class, 'changePrice'])->name('carts.changePrice');

Route::post('/cart/storeWithoutRegistration', [CartController::class, 'storeWithoutRegistration'])->name('carts.withoutregistration.store');
Route::get('/cart/summary', [CartController::class, 'summary'])->name('carts.summary');
Route::post('/cart/saveWithoutRegistration', [CartController::class, 'saveWithoutRegistration'])->name('carts.savewithoutregistration');

use Illuminate\Http\Request;
Route::post('/carts/add-promo', function (Request $request) { 
    $promo_code = $request->input('promo_code');
    $promo = promoCode::where('promo_code', $promo_code)->first();

    // Odpowiedź JSON
   // return response()->json(['success' => true]);
    if($promo){
        $cart = session()->get('cart', []);
        $cart['promo_code'] = '10';
        session()->put('cart', $cart);
        return response()->json(['success' => true, 'discount' => $cart['promo_code']]);
    }else{
        return response()->json(['success' => false]);
    }
});

Route::post('/cart/add-promos', function (Request $request) {
    $promo_code = $request->input('promo_code');
    $promo = promoCode::where('promo_code', $promo_code)->first();
    dd($promo);
})->name('apply.promo.code');
Route::post('/cart/updateDefaultPersonalDetails', [CartController::class, 'updateDefaultPersonalDetails'])->name('carts.updateDefaultPersonalDetails');

Route::resource('contacts', ContactController::class);
Route::post('/contacts/send-mail', [ContactController::class, 'sendMailLetsTalkMail'])->name('contacts.sendMailLetsTalkMail');

Route::resource('AboutUs', AboutUsController::class);

Route::resource('homepage', HomePageController::class);

Route::resource('products', ProductController::class)->only(['index','show','create']);
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('products', ProductController::class)->only(['create','edit','store','destroy','update']);
});

Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/comments', [ProductController::class, 'storeComment'])->name('products.comments.store');
});

Route::post('/products/{product}/add_to_cart', [ProductController::class, 'addToCart'])->name('products.add_to_cart');
Route::post('/products/{product}/add_to_cart_2', [ProductController::class, 'addToCart2'])->name('products.add_to_cart_2');

Route::post('/products/subscribe', [ProductController::class, 'subscribe'])->name('products.subscribe');

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
