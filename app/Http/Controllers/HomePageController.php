<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        // $cart = session()->get('cart', []);
       // return view('cart.index', compact('cart'));
        return view('homepage.index');
    }

    // public function show(String $user)
    // {
    //     return $user;
    // }
}
