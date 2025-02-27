<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\personalDetails;
use App\Models\OrderProduct;
use App\Models\Order;

class CartController extends Controller
{
    public function index()
    {
        $cartData = $this->dataCart();
       // dd($cartData);
        return view('cart.index', $cartData);
    }

    public function details($order_product_id)
    {
        $orderData = Order::where('order_product_id', $order_product_id) -> get();

        $orderProductData = OrderProduct::where('id', $order_product_id) -> first();

        $subtotal = $orderProductData -> subtotal;
        $shipping = $orderProductData -> delivery; 
        $payment = $orderProductData -> payment;
        $promo_code = $orderProductData -> promo_code;
        $total = $orderProductData -> total;

        $personal_details_id = $orderProductData -> personal_details_id;
        $personalDetails = personalDetails::where('id', $orderProductData -> personal_details_id) -> first();
       
        return view('cart.summary', ['products' => $orderData,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'payment' => $payment,
            'promo_code' => $promo_code,
            'total' => $total,
            'enableButtons' => false,
            'summary' => $personalDetails
        ]);
    }

    // public function destroy($id)
    // {
    //     if ($id) {
    //          $cart = session()->get('cart');

    //         if (isset($cart[$id])) {
    //             unset($cart[$id]);
    //             $products = array_filter($cart, 'is_array');

    //             if($products){
    //                 session()->put('cart', $cart);
    //             }else{
    //                 session()->forget('cart');
    //             }
    //         }
    //         session()->flash('success', 'Product removed successfully');
    //     }else{
    //         //session()->flash('success', 'Product not removed successfully');
    //     }
    //     return redirect()->back();
    // }

    public function destroy($id)
    {
        if ($id) {
            $cart = session()->get('cart');
            
           if (isset($cart[$id])) {
                $products = array_filter($cart, 'is_array');
                $keys = array_keys($products);
                if(count($products)>=2){
                    $secondProductId = $keys[1];
                }else{
                    $secondProductId = $keys[0];
                }

                unset($cart[$id]);
               
                if(count($products) >= 2){
                    session()->put('cart', $cart);
                    $subtotal = collect($products)->sum(fn($item) => $item['price'] * $item['quantity']);

                    if (count($products) >= 2) {
                        $reload = false;
                    }elseif (count($products) == 1) {
                        $reload = true; 
                    }

                    return response()->json([
                        'success' => true,
                        'reload' => $reload,
                        'new_subtotal' => $subtotal,
                        'secondProductId' => $secondProductId,
                        'message' => 'Produkt został usunięty z koszyka.'
                        ]);
                }else{
                   session()->forget('cart');
                   //return view('cart.index');
                }
           }
           //session()->flash('success', 'Product removed successfully');
       }else{
           //session()->flash('success', 'Product not removed successfully');
       }
        return response()->json([
            'success' => true,
            'reload' => true,
            'new_subtotal' => 0,
            'secondProductId' => $secondProductId,
            'message' => 'Produkt został usunięty z koszyka.'
        ]);
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
        $OrderProducts = OrderProduct::get();
        return view('cart.order', ['OrderProducts' => $OrderProducts]);
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
    
        //if ($data) {
            $personalDetails = personalDetails::create($data);
            session()->forget('cart_summary');
        //}

        $cartData = $this->dataCart();
        //dd($cartData['promo_code']);
        $orderProduct = [
            //'user_id' => ,
        'personal_details_id' => $personalDetails->id,
        'method_delivery' => $cartData['method_delivery'],
        'method_payment' => $cartData['method_payment'],
        'promo_code' => $cartData['promo_code'],
        'delivery' => $cartData['shipping'],
        'subtotal' => $cartData['subtotal'],
        'total' => $cartData['total'],
        'payment' => $cartData['payment']];

        $orderProduct = OrderProduct::create($orderProduct);
        $order_product_id = $orderProduct -> id;

        $order = array_map(function ($product, $productId) use ($order_product_id) {
            list($productId, $size) = explode('_', $productId);

            return [
                    'product_id' => $productId, 
                    'order_product_id' => $order_product_id, 
                    'name' => $product['name'], 
                    'quantity' => $product['quantity'], 
                    'price' => $product['price'],
                    'size' => $size,
                    'category_products_id' => $product['category_products_id'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
        }, $cartData['products'], array_keys($cartData['products']));

        $order = Order::insert($order);
        session()->forget('cart');

        return redirect()->route('products.index', ['category_products' => 'a'])->with('success', 'Order created successfully');

       // return redirect() -> route('products.index') -> with('succes','Order created succesfully');
    }

    public function summary(){
        $cartData = $this -> dataCart();
        $summary = session('cart_summary', []);

        return view('cart.summary', array_merge($cartData, ['summary' => $summary]));
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
            $promo_code = $cart['promo_code'];

            return compact(
                'cart', 'products', 'subtotal', 'shipping', 'payment', 'total', 'promo_code',
                'method_delivery', 'method_payment'
            );  
        }

        return compact(
            'cart'
        );
    }
}
