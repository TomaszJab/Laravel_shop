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
use App\Http\Resources\CategoryProductsResource;
use App\Http\Requests\ProductRequest;

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
}
