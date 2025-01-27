<?php

namespace App\Http\Controllers;
use App\Mail\AboutUsLetsTalkMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        // $cart = session()->get('cart', []);
       // return view('cart.index', compact('cart'));
        return view('contacts.index');
    }

    public function sendMailLetsTalkMail(Request $request)
    {
        // $cart = session()->get('cart', []);
       // return view('cart.index', compact('cart'));
        Mail::to('zbiorentomologiczny@gmail.com')->send(new AboutUsLetsTalkMail($request));
        //return view('aboutus.index');
        return redirect()->route('contacts.index')->with('success','Email send successfully.');
    }
}
