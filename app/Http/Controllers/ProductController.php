<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CategoryProduct;

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
       // $sortOption = $request->input('selectOption', 'asc');//
       // $products = Product::orderBy('price', $sortOption)->paginate(3);
       $sortOption = $request->query('sortOption', 'desc');
        $categoryName = $request->query('category_products','a');

        // if ($categoryName) {
        //     $products = Product::paginate(4);
        //     return view('products.index',compact('products','sortOption'));
        // }else{
        //     $products = Product::paginate(3);
        //     return view('products.index',compact('products','sortOption'));
        // }
        //$products = Product::where('category_products_id', '1')->paginate(4);
        $products = Product::join('category_products', 'products.category_products_id', '=', 'category_products.id')->where('category_products.name_category_product', $categoryName)->paginate(6);
        
        return view('products.index',compact('products','sortOption'));
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
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        Product::create($request->except('_token'));

        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }

    public function storeComment(Request $request, $productId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($productId);

        $product->comments()->create([
            'content' => $request->input('content'),
            'author' => $request->input('author'),
            'product_id' => $productId,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function addToCart($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $category_products = CategoryProduct::where('id', $product->category_products_id)->first();
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'name_category_product' => $category_products->name_category_product	
            ];
        }

        if (!isset($cart['method_delivery'])) {
            $cart['method_delivery'] = 'Kurier';
        }

        if (!isset($cart['method_payment'])) {
            $cart['method_payment'] = 'AutoPay';
        }

        if (!isset($cart['promo_code'])) {
        $cart['promo_code'] = '';
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
        return view('products.show',compact('product'));
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
}
