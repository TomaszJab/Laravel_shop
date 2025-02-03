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
    
                'gridCheck1' => 'required'
            ]);
        }else{
            $request->validate([
                'email' => 'required',
                'firstName' => 'required',
                'lastName' => 'required',
                'phone' => 'required',

                'company name' => 'required',
                'nip' => 'required',

                'street' => 'required',
                'house_number' => 'required',
                'zip_code' => 'required',
                'city' => 'required',
    
                'gridCheck1' => 'required'
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
        //UserData::create($request->only(['email', 'firstName', 'lastName', 'phone', 'street', 'house_number', 'zip_code', 'city']));

        $data = session('cart_summary');
      
        //dd($data);
        //dd($data['firstName']);
        // $validated = Validator::make($data, [
        //     'firstName' => 'required',
        //     'lastName' => 'required',
        // ]);
    
    
        // Zapisanie danych w bazie
        personalDetails::create([
            'firstName' => $data['firstName']//,
            //'lastName' => $data['lastName']
        ]);
        if ($data) {
           // personalDetails::create($data);
           //personalDetails::create([
            //'firstName' => $data['firstName'] ?? null//,
            //'lastName' => $data['lastName'] ?? null,
        //]);

            session()->forget('cart_summary');
        }
    }
}
