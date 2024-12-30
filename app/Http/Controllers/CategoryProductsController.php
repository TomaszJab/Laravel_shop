<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryProductsController extends Controller
{
    public function index()
    {
        // $cart = session()->get('cart', []);
       // return view('cart.index', compact('cart'));
        return view('aboutus.index');
    }
}
