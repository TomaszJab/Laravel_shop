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
// Route::delete('/cart/AJAX_destroy', [CartController::class, 'AJAX_destroy'])->name('carts.AJAX_destroy');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('carts.clear');
Route::post('/cart/changequantity', [CartController::class, 'changequantity'])->name('carts.changequantity');
Route::get('/cart/delivery', [CartController::class, 'delivery'])->name('carts.delivery');
Route::get('/cart/order', [CartController::class, 'order'])->name('carts.order');
Route::get('/cart/order/details/{order_product_id}', [CartController::class, 'details'])->name('carts.order.details');
Route::get('/cart/buyWithoutRegistration', [CartController::class, 'buyWithoutRegistration'])->name('carts.buyWithoutRegistration');
Route::post('/cart/changePrice', [CartController::class, 'changePrice'])->name('carts.changePrice');

Route::post('/cart/storewithoutregistration', [CartController::class, 'storewithoutregistration'])->name('carts.withoutregistration.store');
Route::get('/cart/summary', [CartController::class, 'summary'])->name('carts.summary');
Route::post('/cart/savewithoutregistration', [CartController::class, 'savewithoutregistration'])->name('carts.savewithoutregistration');
use Illuminate\Http\Request;
Route::post('/carts/add-promo', function (Request $request) {
    // $request->validate([
    //     'promo_code' => 'required|unique:promo_codes,promo_code',
    //     'valid_from' => 'required|date',
    //     'valid_until' => 'nullable|date|after_or_equal:valid_from',
    // ]);

    // Dodanie kodu rabatowego do bazy danych
    // $promo = promoCode::create([
    //     'promo_code' => $request->input('promo_code'),
    //     'valid_from' => $request->input('valid_from'),
    //     'valid_until' => $request->input('valid_until') ?: null, // Ustawienie null, jeśli 'valid_until' jest pusty
    // ]);
 
    $promo_code = $request->input('promo_code');
    $promo = promoCode::where('promo_code', $promo_code)->first();

  //->where('votes', '=', 100)

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

Route::get('/log',function(){
    return view('log.index');
})->name('log');

Route::resource('contacts', ContactController::class);
Route::post('/contacts/send-mail', [ContactController::class, 'sendMailLetsTalkMail'])->name('contacts.sendMailLetsTalkMail');

Route::resource('AboutUs', AboutUsController::class);

Route::resource('homepage', HomePageController::class);

Route::resource('products', ProductController::class);
// Route::get('products', [ProductController::class, 'category_products'])->name('products.category_products');;
Route::post('/products/{product}/comments', [ProductController::class, 'storeComment'])->name('products.comments.store');
Route::post('/products/{product}/add_to_cart', [ProductController::class, 'addToCart'])->name('products.add_to_cart');

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

require __DIR__.'/auth.php';
