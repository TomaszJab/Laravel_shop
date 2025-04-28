<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiresource('carts', CartController::class);
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('carts.clear');
Route::post('/cart/changequantity', [CartController::class, 'changequantity'])->name('carts.changequantity');
Route::get('/cart/delivery', [CartController::class, 'delivery'])->name('carts.delivery');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart/order', [CartController::class, 'order'])->name('carts.order');
    Route::get('/cart/order/details/{order_product_id}', [CartController::class, 'details'])->name('carts.order.details');
});

Route::get('/cart/buy', [CartController::class, 'buyWithoutRegistration'])->name('carts.buyWithoutRegistration');
Route::post('/cart/changePrice', [CartController::class, 'changePrice'])->name('carts.changePrice');

Route::post('/cart/storewithoutregistration', [CartController::class, 'storewithoutregistration'])->name('carts.withoutregistration.store');
Route::get('/cart/summary', [CartController::class, 'summary'])->name('carts.summary');
Route::post('/cart/savewithoutregistration', [CartController::class, 'savewithoutregistration'])->name('carts.savewithoutregistration');

use App\Models\promoCode;
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

// Route::resource('contacts', ContactController::class);
// Route::post('/contacts/send-mail', [ContactController::class, 'sendMailLetsTalkMail'])->name('contacts.sendMailLetsTalkMail');

// Route::resource('AboutUs', AboutUsController::class);

// Route::resource('homepage', HomePageController::class);


Route::apiresource('/products', ProductController::class)->only(['index','show']);
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiresource('products', ProductController::class)->only(['create','edit','store','destroy','update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products/{product}/comments', [ProductController::class, 'storeComment'])->name('products.comments.store');
});

Route::post('/products/{product}/add_to_cart', [ProductController::class, 'addToCart'])->name('products.add_to_cart');
//Route::post('/products/{product}/add_to_cart_2', [ProductController::class, 'addToCart2'])->name('products.add_to_cart_2');

Route::post('/products/subscribe', [ProductController::class, 'subscribe'])->name('products.subscribe');

// Route::resource('statutes', StatuteController::class);

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::get('/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
// Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');


//to na dole to test jak co dziala
Route::get('/test', function () {
    $user = Auth::guard('sanctum')->user(); 
    return response()->json([
        'user_id' => $user ? $user->id : null,
        'user_isAdmin' => $user ? $user->isAdmin() : null,
        'auth(sanctum)->check()' => auth('sanctum')->check(),
        'message' => 'To jest testowy endpoint API bez logowania!',
        'status' => 'success'
    ]);
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Podano błędne dane logowania.'],
        ]);
    }

    // Tworzymy token dla użytkownika
    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
});