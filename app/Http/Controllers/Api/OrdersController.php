<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\OrderService;
use App\Http\Services\OrderProductService;
use App\Http\Services\PersonalDetailsService;
use App\Http\Services\ProductService;
use App\Http\Services\CartService;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Resources\OrderProductResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\PersonalDetailsResource;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    protected $orderService;
    protected $orderProductService;
    protected $personalDetailsService;
    protected $productService;
    protected $cartService;

    public function __construct(
        OrderService $orderService,
        OrderProductService $orderProductService,
        PersonalDetailsService $personalDetailsService,
        ProductService $productService,
        CartService $cartService
    ) {
        $this->orderService = $orderService;
        $this->orderProductService = $orderProductService;
        $this->personalDetailsService = $personalDetailsService;
        $this->productService = $productService;
        $this->cartService = $cartService;
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('sanctum')->user();
        $userIsAdmin = $user->isAdmin();

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

    public function create() //do zrobienia///////////////////////////////////////////////
    {
        $cartData = $this->cartService->dataCart();
        return view('cart.delivery', $cartData);
    }

    public function show($orderProductId)
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

    public function store(PersonalDetailsRequest $request)
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
}
