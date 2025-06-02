<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Services\OrderService;
use App\Http\Services\OrderProductService;
use App\Http\Services\PersonalDetailsService;
use App\Http\Services\ProductService;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Resources\OrderProductResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PersonalDetailsResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryProductsResource;

class CartController extends Controller
{
    protected $orderService;
    protected $orderProductService;
    protected $personalDetailsService;
    protected $productService;

    public function __construct(
        OrderService $orderService,
        OrderProductService $orderProductService,
        PersonalDetailsService $personalDetailsService,
        ProductService $productService
    ) {
        $this->orderService = $orderService;
        $this->orderProductService = $orderProductService;
        $this->personalDetailsService = $personalDetailsService;
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    // }

    public function details($orderProductId)
    {
        $orderData = $this->orderService->getOrdersByOrderProductId($orderProductId);
        $orderProductData = $orderData->first()->orderProduct;

        $personalDetailsId = $orderProductData->personal_details_id;
        $personalDetails = $this->personalDetailsService->getPersonalDetailByPersonalDetailsId($personalDetailsId);

        return [
            'products' => OrderResource::collection($orderData),
            'orderProductData' => OrderProductResource::make($orderProductData),
            'enableButtons' => false,
            'summary' => PersonalDetailsResource::make($personalDetails)
        ];
    }

    //public function destroy($id)
    //public function delete()
    //public function changeQuantity(Request $request)
    //public function delivery()

    public function order()
    {
        $userIsAdmin = Auth::guard('sanctum')->user()->isAdmin();

        if ($userIsAdmin) {
            $products = $this->productService->getAllProductPaginate(8);
            $orderProducts = $this->orderProductService->getAllOrderProductPaginate(8);

            return [
                'orderProducts' => OrderProductResource::collection($orderProducts),
                'products' => ProductResource::collection($products)
            ];
        } else {
            $user = Auth::guard('sanctum')->user();
            $idUser = $user->id;
            $orderProducts = $this->orderProductService->getAllOrderProductPaginateByIdUser($idUser, 8);
            $defaultPersonalDetails = $this->personalDetailsService->getDefaultPersonalDetailsByUserId($idUser);
            $additionalPersonalDetails = $this->personalDetailsService->getAdditionalPersonalDetailsByUserId($idUser);

            return [
                'orderProducts' => OrderProductResource::collection($orderProducts),
                'personalDetails' => PersonalDetailsResource::make($defaultPersonalDetails),
                'additionalPersonalDetails' => PersonalDetailsResource::make($additionalPersonalDetails)
            ];
        }
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

    public function saveWithoutRegistration(PersonalDetailsRequest $request)
    {
        $dataPersonalDetails = $request->input('personal_details');
        //session('cart_summary');

        $idUser = Auth::guard('sanctum')->user()->id ?? null;
        //$idUser = auth()->user()->id ?? null;
        $dataPersonalDetails['user_id'] = $idUser;
        //if ($data) {

        $personalDetails = $this->personalDetailsService->store($request, $dataPersonalDetails);
        //personalDetails::create($data);
        //to nie bedzie
        // session()->forget('cart_summary');
        //}

        //$cartData = $this->dataCart();
        $cartData = $request->input('cart_data');
        // if (!$cartData || !isset($cartData['products'])) {
        //     return response()->json(['error' => 'Invalid cart data'], 422);
        // }

        $this->orderService->storeOrderBasedOnOrderProduct($idUser, $personalDetails, $cartData);

        //session()->forget('cart');

        return response()->json(['message' => 'Order created successfully'], 201);
    }

    // public function summary()//////////////
    // {
    //     $cartData = $this->dataCart();
    //     $summary = session('cart_summary', []);

    //     return view('cart.summary', array_merge($cartData, ['summary' => $summary]));
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    // public function show(Product $product)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Product $product)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Product $product)
    // {
    //     //
    // }
}
