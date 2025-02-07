<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\personalDetails;
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

    public function changequantity(Request $request)
    {
        $action = $request->input("action");
        $product_id = $request->input("product_id");
        $cart = session()->get('cart', []);

        if (!isset($cart[$product_id])) {
            return redirect()->back()->with('error', 'Produkt nie znaleziony w koszyku.');
        }

        if($action == "decrease"){
            $cart[$product_id]['quantity'] -= 1;
        }elseif($action == "increase"){
            $cart[$product_id]['quantity'] += 1;
        }

        session()->put('cart', $cart);

        return redirect()->back();
    }

    public function delivery()
    {
        return view('cart.delivery');
    }

    public function order()
    {
        return view('cart.order');
    }

    public function buyWithoutRegistration()
    {
        return view('cart.buyWithoutRegistration');
    }

    public function storewithoutregistration(Request $request)
    {
        $company_or_private_person = $request->input('company_or_private_person');
        
        if ( $company_or_private_person == 'private_person') {
            $request->validate([
                'email' => 'required',
                'firstName' => 'required',
                'lastName' => 'required',
                'phone' => 'required',
    
                'street' => 'required',
                'house_number' => 'required',
                'zip_code' => 'required',
                'city' => 'required',
    
                'acceptance_of_the_regulations' => 'required'
            ]);
        }else{
            $request->validate([
                'email' => 'required',
                'firstName' => 'required',
                'lastName' => 'required',
                'phone' => 'required',

                'company_name' => 'required',
                'nip' => 'required',

                'street' => 'required',
                'house_number' => 'required',
                'zip_code' => 'required',
                'city' => 'required',
    
                'acceptance_of_the_regulations' => 'required'
            ]);
        }
     
        // Product::create($request->except('_token'));

        //$summary = $request->only('firstName', 'lastName');
        $summary = $request->except('_token');

        // Przekazanie danych do sesji
        session(['cart_summary' => $summary]);
        return redirect()->route('carts.summary');
                        //->with('success','Product created successfully.');
    }

    public function savewithoutregistration(Request $request)
    {
        $data = session('cart_summary');
      
        //dd($data);
    
        if ($data) {
            personalDetails::create($data);
            session()->forget('cart_summary');
        }
        return redirect()->route('products.index')->with('succes','Order created succesfully');
    }
}
