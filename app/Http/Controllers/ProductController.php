<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CategoryProduct;
use App\Http\Services\ProductService;
use App\Http\Services\CategoryProductService;
use App\Http\Services\CommentService;
use App\Http\Services\SubscriberService;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\SubscriberRequest;
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

    public function addToCart2($id, Request $request)
    {
        $this->addToCart($id, $request);
        return redirect()->route('carts.index');
    }

    public function addToCart($id, Request $request)
    {
        $product = $this->productService->getProductById($id);
        $cart = session()->get('cart', []);

        $size = $request->input('size');
        $quantity = $request->input('quantity');
        $key = $product->id . '_' . $size;

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

        session()->put('cart', $cart);

        return back(); #->with('success', 'Produkt dodany do koszyka!');
    }

    public function show(Product $product)
    {
        $comments = $product->comments()->orderBy('created_at', 'desc')->get();

        return view('products.show', compact('product', 'comments'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
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
