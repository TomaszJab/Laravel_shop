<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

use App\Http\ApiControllers\ProductApiController;
use App\Http\ApiControllers\CartApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/products', ProductApiController::class);
Route::post('/products/subscribe', [ProductApiController::class, 'subscribe'])->name('products.subscribe');
//orginalnie jest tu post ale to jest api i tutaj get
Route::get('/products/{product}/add_to_cart', [ProductApiController::class, 'addToCart'])->name('products.add_to_cart');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart/order', [CartApiController::class, 'order'])->name('carts.order');
    Route::get('/cart/order/details/{order_product_id}', [CartApiController::class, 'details'])->name('carts.order.details');
    Route::post('/products/{product}/comments', [ProductApiController::class, 'storeComment'])->name('products.comments.store');
});

Route::get('/cart/buy', [CartApiController::class, 'buyWithoutRegistration'])->name('carts.buyWithoutRegistration');
Route::post('/cart/savewithoutregistration', [CartApiController::class, 'savewithoutregistration'])->name('carts.savewithoutregistration');
Route::post('/cart/updateDefaultPersonalDetails', [CartApiController::class, 'updateDefaultPersonalDetails'])->name('carts.updateDefaultPersonalDetails');

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