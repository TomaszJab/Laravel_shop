<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromoCode;

class PromoCodeController extends Controller
{
    public function checkPromo(Request $request)//get
    {
        $promoCode = $request->input('promo_code');
        $promo = PromoCode::where('promo_code', $promoCode)->first();

        // Odpowiedź JSON
        // return response()->json(['success' => true]);
        if ($promo) {
            $cart = session()->get('cart', []);
            $cart['promo_code'] = '10';
            session()->put('cart', $cart);
            return response()->json(['success' => true, 'discount' => $cart['promo_code']]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
