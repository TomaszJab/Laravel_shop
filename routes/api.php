<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\PersonalDetailsController;
use App\Http\Controllers\Api\PromoCodeController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;

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
//
Route::apiresource('cart', CartController::class)->only(['create','destroy']);

Route::post('/cart/clear', [CartController::class, 'destroyAll'])->name('carts.clear');
Route::post('/cart/updateQuantity', [CartController::class, 'updateQuantity'])->name('carts.updateQuantity');
Route::get('/order/create', [OrdersController::class, 'create'])->name('orders.create');

Route::middleware('auth:sanctum', 'verified')->group(function () {
    Route::get('/order', [OrdersController::class, 'index'])->name('orders.index');
});

Route::middleware('auth:sanctum', 'ownerOrAdmin')->group(function () {
    Route::get('/order/{orderProductId}', [OrdersController::class, 'show'])->name('orders.show');
});

Route::get('/personalDetails/create', [PersonalDetailsController::class, 'create'])->name('personalDetails.create');
Route::post('/cart/updatePrice', [CartController::class, 'updatePrice'])->name('carts.updatePrice');

Route::post('/personalDetail/walidation', [PersonalDetailsController::class, 'walidate'])->name('personalDetails.walidate');
Route::get('/cart/show', [CartController::class, 'summary'])->name('carts.show');
Route::post('/order/store', [OrdersController::class, 'store'])->name('orders.store');

Route::post('/promoCode/checkPromo', [PromoCodeController::class, 'checkPromo'])->name('promoCodes.checkPromo');

Route::post('/personalDetail/store', [PersonalDetailsController::class, 'store'])->name('personalDetails.store');

// Route::resource('contacts', ContactController::class);
// Route::post('/contacts/sendMail', [ContactController::class, 'sendMail'])->name('contacts.sendMail');

// Route::resource('aboutUs', AboutUsController::class);

// Route::resource('homepage', HomePageController::class);


Route::apiresource('/products', ProductController::class)->only(['index','show','create']);
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiresource('products', ProductController::class)->only(['create', 'edit', 'store', 'destroy', 'update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('products.comments.store');
});

Route::post('/products/{product}/addToCart', [CartController::class, 'storeAndRedirect'])->name('carts.addToCart');
//Route::post('/products/{product}/addToCart2', [ProductController::class, 'store'])->name('carts.addToCart2');

Route::post('/subscriber/store', [SubscriberController::class, 'store'])->name('subscribers.store');

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

/////////////////////////////////////////////////////////////////////////////////////////////
//to na dole to test jak coś dziala
// use Illuminate\Support\Facades\Auth;
// Route::get('/test', function () {
//     $user = Auth::guard('sanctum')->user();
//     return response()->json([
//         'user_id' => $user ? $user->id : null,
//         'user_isAdmin' => $user ? $user->isAdmin() : null,
//         'auth(sanctum)->check()' => auth('sanctum')->check(),
//         'message' => 'To jest testowy endpoint API bez logowania!',
//         'status' => 'success'
//     ]);
// });

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'logout']);
});

// Route::post('/login', function (Request $request) {
//     $request->validate([
//         'email' => 'required|email',
//         'password' => 'required'
//     ]);

//     $user = User::where('email', $request->email)->first();

//     if (! $user || ! Hash::check($request->password, $user->password)) {
//         throw ValidationException::withMessages([
//             'email' => ['Podano błędne dane logowania.'],
//         ]);
//     }

//     // Tworzymy token dla użytkownika
//     $token = $user->createToken('api-token')->plainTextToken;

//     return response()->json([
//         'token' => $token,
//         'user' => $user
//     ]);
// });
