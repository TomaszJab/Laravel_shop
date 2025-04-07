<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\Subscriber;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$sortOption = $request->query('sortOption', 'asc');
        $sortOption = $request->query('sortOption');
        $categoryName = $request->query('category_products','a');
        $favoriteProduct = Product::orderBy('favorite', 'desc')->firstOrFail();

        $category_products = CategoryProduct::where('name_category_product', $categoryName)->firstOrFail();
        if($sortOption){
            $products = $category_products->products()->orderBy('name', $sortOption)->paginate(6);
        }else{
            $products = $category_products->products()->orderBy('favorite', 'desc')->paginate(6);
        }
        
        return view('products.index',compact('products', 'sortOption', 'favoriteProduct'));
    }

    // public function category_products(Request $request)
    // {
        // Fetch products based on the category passed in the route
        // $products = Product::where('category', $category_products)->get();

        // Return the view with the products and the selected category
        // return view('products.index', compact('products', 'category_products'));

    //     $products = Product::paginate(3);
    //     return view('products.index',compact('products'));
    // }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryProduct = CategoryProduct::all();
        return view('products.create',compact('categoryProduct'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'detail' => 'required',
            'category_products_id' => 'required'
        ]);

        Product::create($request->except('_token'));

        return redirect()->route('products.index')->with('success','Product created successfully.');
    }

    public function storeComment(Request $request, $productId)
    {
        $request->validate([
            'content' => 'required|string|max:255'
        ]);

        $product = Product::findOrFail($productId);
        $nameUser = auth()->user()->name;

        $product->comments()->create([
            'content' => $request->input('content'),
            'author' => $nameUser,
            'product_id' => $productId
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function addToCart_2($id, Request $request){
        $this -> addToCart($id, $request);
        return redirect()->route('carts.index');
    }

    public function addToCart($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $category_products = CategoryProduct::where('id', $product->category_products_id)->first();
        $cart = session()->get('cart', []);

        $size = $request->input('size');
        $quantity = $request->input('quantity');
        $key = $product->id.'_'.$size;
        
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $cart[$key]['quantity'] + $quantity;
        } else {
            $cart[$key] = [
                'name' => $product -> name,
                'quantity' => 1,
                'price' => $product -> price,
                'name_category_product' => $category_products -> name_category_product,
                'category_products_id' => $product -> category_products_id
            ];
        }

        if (!isset($cart['method_delivery'])) {
            $cart['method_delivery'] = 'Kurier';
        }

        if (!isset($cart['method_payment'])) {
            $cart['method_payment'] = 'AutoPay';
        }

        if (!isset($cart['promo_code'])) {
            $cart['promo_code'] = null;
        }

        if (!isset($cart['delivery'])) {
            $cart['delivery'] = number_format(25,2);
        }
    
        if (!isset($cart['payment'])) {
            $cart['payment'] = number_format(0,2);
        }

        session()->put('cart', $cart);

        return back(); #->with('success', 'Produkt dodany do koszyka!');
    }

    public function show(Product $product)
    {
        $comments = $product->comments()->orderBy('created_at', 'desc')->get();
        return view('products.show',compact('product', 'comments'));
    }

    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'detail' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }

    public function subscribe(Request $request){
        $email_address = $request->input('email_address');
        $data = $request->validate(['email_address' => 'required|email']);

        $email_subscriber = [
            'email_subscriber' => $email_address
        ];

        Subscriber::create($email_subscriber);

        return redirect()->route('products.index', ['category_products' => 'a'])->with('success', 'You are a subscriber!');
    }
}
