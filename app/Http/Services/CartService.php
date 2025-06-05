<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartService extends Controller
{
    public function dataCart()
    {
        $cart = session('cart');

        if ($cart) {
            $products = array_filter($cart, 'is_array'); // Pobierz tylko produkty
            $subtotal = number_format(collect($products)->sum(fn($item) => $item['price'] * $item['quantity']), 2);
            $shipping = $cart['delivery'];
            $payment = $cart['payment'];

            $total = number_format($subtotal + $shipping + $payment, 2);
            if ($cart['promo_code'] <> '') {
                $total = number_format($total - ($total * $cart['promo_code']) / 100, 2);
            }

            $method_delivery = $cart['method_delivery'];
            $method_payment = $cart['method_payment'];
            $promo_code = $cart['promo_code'];

            return compact(
                'cart',
                'products',
                'subtotal',
                'shipping',
                'payment',
                'total',
                'promo_code',
                'method_delivery',
                'method_payment'
            );
        }

        return compact(
            'cart'
        );
    }
}
