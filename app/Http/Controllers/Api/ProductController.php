<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct; //to potem pewnie sie nie przyda
use App\Http\Services\ProductService;
use App\Http\Services\CategoryProductService;
use App\Http\Services\CommentService;
use App\Http\Services\SubscriberService;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\SubscriberResource;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\SubscriberRequest;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryProductService;
    protected $commentService;
    protected $subscriberService;

    public function __construct(
        ProductService $productService,
        CategoryProductService $categoryProductService,
        CommentService $commentService,
        SubscriberService $subscriberService
    ) {
        $this->productService = $productService;
        $this->categoryProductService = $categoryProductService;
        $this->commentService = $commentService;
        $this->subscriberService = $subscriberService;
    }
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $products = $this -> productService -> getAllProducts();
    //     return $products;
    // }

    //przyklad, mogą też być inne http://127.0.0.1:8000/api/products?category_products=a
    public function index(Request $request)
    {
        $sortOption = $request->query('sortOption');
        $categoryName = $request->query('category_products', 'a');
        $favoriteProduct = $this->productService->getProductOrderByFavorite('desc');
        //Product::orderBy('favorite', 'desc')->firstOrFail();

        $products = $this->categoryProductService->getProductsByCategoryName($categoryName, $sortOption);
        // CategoryProduct::where('name_category_product', $categoryName)->firstOrFail();
        // if($sortOption){
        //     $products = $category_products->products()->orderBy('name', $sortOption)->paginate(6);
        // }else{
        //     $products = $category_products->products()->orderBy('favorite', 'desc')->paginate(6);
        // }

        //return view('products.index',compact('products', 'sortOption', 'favoriteProduct'));
        //return response()->json(compact('products', 'sortOption', 'favoriteProduct'));
        return [
            'products' => ProductResource::collection($products),
            'sortOption' => $sortOption, // zwykła wartość
            'favoriteProduct' => ProductResource::make($favoriteProduct),
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $product = $this -> productService -> store($request);
    //     return response() -> json($product, 201);
    // }

    // post http://127.0.0.1:8000/api/products
    // {
    //     "name": "Nowy Produkt",
    //     "price": 99.99,
    //     "detail": "Opis produktu",
    //     "category_products_id": "1"
    //   }
    public function store(ProductRequest $request)
    {
        $product = $this->productService->store($request);
        //Product::create($request->except('_token'));

        return response()->json($product, 201);
        //return redirect()->route('products.index')->with('success','Product created successfully.');
    }

    // POST http://127.0.0.1:8000/api/products/2/comments
    // {
    //     "content": "Nowy Produkt"
    // }
    public function storeComment(CommentRequest $request, $productId)
    {
        $comment = $this->commentService->store($request, $productId);
        //$product = Product::findOrFail($productId);
        // $nameUser = auth()->user()->name;

        // $product->comments()->create([
        //     'content' => $request->input('content'),
        //     'author' => $nameUser,
        //     'product_id' => $productId
        // ]);
        return response()->json($comment, 201);
        //return redirect()->back()->with('success', 'Comment added successfully!');
    }

    // to raczej sie tutaj nie przyda
    // public function addToCart_2($id, Request $request){
    //     $this -> addToCart($id, $request);
    //     return redirect()->route('carts.index');
    // }

    public function addToCart($id, Request $request) ///////////////////
    {
        $product = Product::findOrFail($id);
        $category_products = CategoryProduct::where('id', $product->category_products_id)->first(); //$categoryProducts
        //$cart = session()->get('cart', []);

        //$size = $request->input('size');
        //$quantity = $request->input('quantity');
        // $key = $product->id.'_'.$size;

        // if (isset($cart[$key])) {
        //     $cart[$key]['quantity'] = $cart[$key]['quantity'] + $quantity;
        // } else {
        //     $cart[$key] = [
        //         'name' => $product -> name,
        //         'quantity' => 1,
        //         'price' => $product -> price,
        //         'name_category_product' => $category_products -> name_category_product,
        //         'category_products_id' => $product -> category_products_id
        //     ];
        //     $cart['method_delivery'] = 'Kurier';
        //     $cart['method_payment'] = 'AutoPay';
        //     $cart['promo_code'] = null;
        //     $cart['delivery'] = number_format(25,2);
        //     $cart['payment'] = number_format(0,2);
        // }

        // session()->put('cart', $cart);
        return response()->json(compact('product', 'category_products'));
        //return back(); #->with('success', 'Produkt dodany do koszyka!');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Product $product)
    // {
    //     $product = $this -> productService -> show($product);
    //     return $product;
    // }

    public function show(Product $product)
    {
        //getCommenstOrderByCreatedAt
        $comments = $this->commentService->getCommenstsOrderByCreatedAt($product, 'desc');
        //$comments = $product->comments()->orderBy('created_at', 'desc')->get();
        //return view('products.show',compact('product', 'comments'));
        return [
            'product' => ProductResource::make($product),
            'comments' => CommentResource::collection($comments)
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Product $product)
    // {
    //     $this -> productService -> update($request, $product);
    //     return response() -> json($product, 200);
    // }
    public function update(ProductRequest $request, Product $product) ///?
    {
        // return redirect()->route('products.index')
        //                 ->with('success','Product updated successfully');
        $product = $this->productService->update($request, $product);
        //return response()->json($product, 200);

        return [
            'product' => ProductResource::make($product)
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Product $product)
    // {
    //     $product = $this -> productService -> delete($product);
    //     return response() -> json(null, 204);
    // }
    public function destroy(Product $product)
    {
        // $product->delete();

        // return redirect()->route('products.index')
        //                 ->with('success','Product deleted successfully');
        $product = $this->productService->destroy($product);
        return response()->json(null, 204);
    }

    public function subscribe(SubscriberRequest $request)
    {
        $subscriber = $this->subscriberService->store($request);
        //Subscriber::create($email_subscriber);

        //return response()->json($subscriber, 201);
        return response()->json([
            'subscriber' => new SubscriberResource($subscriber),
        ], 201);
        //return redirect()->route('products.index',
        // ['category_products' => 'a'])->with('success', 'You are a subscriber!');
    }
}
