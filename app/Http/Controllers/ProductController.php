<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Services\ProductService;
use App\Http\Services\CategoryProductService;
use App\Http\Services\CommentService;
use App\Http\Services\SubscriberService;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

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

        return view('products.index', compact('products', 'sortOption', 'favoriteProduct'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryProduct = $this->categoryProductService->getAllCategory();
        return view('products.create', compact('categoryProduct'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $this->productService->store($request);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $comments = $this->commentService->getCommenstsOrderByCreatedAt($product, 'desc');

        return view('products.show', compact('product', 'comments'));
    }

    public function edit(Product $product)
    {
        $categoryProducts = $this->categoryProductService->getAllCategory();
        return view('products.edit', compact('product', 'categoryProducts'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->productService->update($request, $product);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $this->productService->destroy($product);

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
