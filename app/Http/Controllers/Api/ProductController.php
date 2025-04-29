<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Services\ProductService;
use App\Http\Services\CategoryProductService;
use App\Http\Services\CommentService;
use App\Http\Services\SubscriberService;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\SubscriberResource;
use App\Http\Resources\CategoryProductsResource;
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
    public function index(Request $request)
    {
        $sortOption = $request->query('sortOption');
        $categoryName = $request->query('category_products', 'a');

        $favoriteProduct = $this->productService->getProductOrderByFavorite('desc');
        $products = $this->categoryProductService->getProductsByCategoryName($categoryName, $sortOption);

        return [
            'products' => ProductResource::collection($products),
            'sortOption' => $sortOption,
            'favoriteProduct' => ProductResource::make($favoriteProduct),
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = $this->productService->store($request);
        return response()->json($product, 201);
    }

    public function storeComment(CommentRequest $request, $productId)
    {
        $comment = $this->commentService->store($request, $productId);
        return response()->json($comment, 201);
    }

    // to raczej sie tutaj nie przyda
    // public function addToCart_2($id, Request $request){
    //     $this -> addToCart($id, $request);
    //     return redirect()->route('carts.index');
    // }

    public function addToCart($id, Request $request)
    {
        $product = $this->productService->getProductById($id);
        $categoryProducts = $product->categoryProducts()->first();

        $size = $request->input('size');
        $quantity = $request->input('quantity');
        $key = $product->id . '_' . $size;

        /* //kod po stronie aplikacji telefonu
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $cart[$key]['quantity'] + $quantity;
        } else {
            $categoryProducts = $product->categoryProducts()->first();

            $cart[$key] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'name_category_product' => $categoryProducts->name_category_product,
                'category_products_id' => $product->category_products_id
            ];

            if (!isset($cart['method_delivery'])) {
                $cart['method_delivery'] = 'Kurier';
                $cart['method_payment'] = 'AutoPay';
                $cart['promo_code'] = null;
                $cart['delivery'] = number_format(25, 2);
                $cart['payment'] = number_format(0, 2);
            }
        }

        session()->put('cart', $cart);*/

        // return back();
        //return response()->json(compact('product', 'category_products'));
        return [
            'product' => ProductResource::make($product),
            'categoryProducts' => CategoryProductsResource::make($categoryProducts),
            'quantity' => $quantity,
            'key' => $key
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $comments = $this->commentService->getCommenstsOrderByCreatedAt($product, 'desc');

        return [
            'product' => ProductResource::make($product),
            'comments' => CommentResource::collection($comments)
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product = $this->productService->update($request, $product);

        return [
            'product' => ProductResource::make($product)
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product = $this->productService->destroy($product);

        return response()->json(null, 204);
    }

    public function subscribe(SubscriberRequest $request)
    {
        $subscriber = $this->subscriberService->store($request);

        return response()->json([
            'subscriber' => new SubscriberResource($subscriber),
        ], 201);
    }
}
