<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PromoCodeService;

class PromoCodeController extends Controller
{
    protected $promoCode;

    public function __construct(
        PromoCodeService $promoCode
    ) {
        $this->promoCode = $promoCode;
    }

    public function checkPromo(Request $request) //get
    {
        $promoCode = $request->input('promo_code');
        $promo = $this->promoCode->checkPromo($promoCode);

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
