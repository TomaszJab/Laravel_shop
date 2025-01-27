<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function destroy($id)
    {
        if ($id) {
             $cart = session()->get('cart');

            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }else{
            //session()->flash('success', 'Product not removed successfully');
        }
        return redirect()->back();
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back();
    }

    public function delivery()
    {
        return view('cart.delivery');
    }

}
