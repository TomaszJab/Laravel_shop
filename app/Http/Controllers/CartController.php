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
        $cartData = $this->dataCart();
        return view('cart.index',$cartData);
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
            return response()->json(['success' => false, 'message' => 'Produkt nie znaleziony w koszyku.']);
            //return redirect()->back()->with('error', 'Produkt nie znaleziony w koszyku.');
        }

        if($action == "decrease"){
            if($cart[$product_id]['quantity']> 1){
                $cart[$product_id]['quantity'] -= 1;
            }
        }elseif($action == "increase"){
            $cart[$product_id]['quantity'] += 1;
        }
        
        $products = array_filter($cart, 'is_array');
        $subtotal = number_format(collect($products)->sum(fn($item) => $item['price'] * $item['quantity']), 2);

        $subtotalProduct = number_format(  $cart[$product_id]['price'] * $cart[$product_id]['quantity'], 2);
        session()->put('cart', $cart);
        
        return response()->json(['success' => true, 
        'new_quantity' => $cart[$product_id]['quantity'],
        'new_subtotal' => $subtotal,
        'new_subtotalProduct' => $subtotalProduct
        ]);
        
        //return redirect()->back();
    }

    public function changePrice(Request $request)
    {
        $price = str_replace('$', '', $request->input("price"));
        $method = $request->input("method");
        $change = $request->input("change");
        
        $cart = session()->get('cart', []);

        if($change == "Price"){
            $cart['delivery'] = $price;
            $cart['method_delivery'] = $method;
        }elseif($change == "Payment"){
            $cart['payment'] = $price;
            $cart['method_payment'] = $method;
        }

        session()->put('cart', $cart);
        
        return response()->json(['success' => true]);
    }
    
    public function delivery()
    {
        $cartData = $this->dataCart();
        return view('cart.delivery', $cartData);
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
    
    private function dataCart(){
        $cart = session('cart');
        
        if($cart){
            $products = array_filter($cart, 'is_array'); // Pobierz tylko produkty
            $subtotal = number_format(collect($products)->sum(fn($item) => $item['price'] * $item['quantity']),2);
            $shipping = $cart['delivery'];
            $payment = $cart['payment'];
            
            $total = number_format($subtotal + $shipping + $payment,2);
            if ($cart['promo_code']<>''){
                $total = number_format($total - ($total * $cart['promo_code'])/100,2);
            }
            
            $method_delivery = $cart['method_delivery'];
            $method_payment = $cart['method_payment'];
    
            return compact(
                'cart', 'products', 'subtotal', 'shipping', 'payment', 'total', 
                'method_delivery', 'method_payment'
            );  
        }

        return compact(
            'cart'
        );
    }
}
