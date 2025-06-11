<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\OrderService;
use App\Http\Services\StatuteService;
use App\Http\Services\OrderProductService;
use App\Http\Services\PersonalDetailsService;
use App\Http\Services\ProductService;
use App\Http\Services\CartService;
use App\Http\Requests\PersonalDetailsRequest;

class OrdersController extends Controller
{
    protected $orderService;
    protected $orderProductService;
    protected $personalDetailsService;
    protected $productService;
    protected $cartService;
    protected $statuteService;

    public function __construct(
        OrderService $orderService,
        OrderProductService $orderProductService,
        PersonalDetailsService $personalDetailsService,
        ProductService $productService,
        CartService $cartService,
        StatuteService $statuteService
    ) {
        $this->orderService = $orderService;
        $this->orderProductService = $orderProductService;
        $this->personalDetailsService = $personalDetailsService;
        $this->productService = $productService;
        $this->cartService = $cartService;
        $this->statuteService = $statuteService;
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $userIsAdmin = $user->isAdmin();

        if ($userIsAdmin) {
            $products = $this->productService->getAllProductPaginate(8);
            $orderProducts = $this->orderProductService->getAllOrderProductPaginate(8);
            $statutes = $this->statuteService->getAllStatuteTransformContentAndPaginate(8);

            return view('order.index', [
                'OrderProducts' => $orderProducts,
                'products' => $products,
                'statutes' => $statutes
            ]);
        } else {
            $idUser = auth()->user()->id;

            $orderProducts = $this->orderProductService->getAllOrderProductPaginateByIdUser($idUser, 8);
            $defaultPersonalDetails = $this->personalDetailsService->getDefaultPersonalDetailsByUserId($idUser);
            $additionalPersonalDetails = $this->personalDetailsService->getAdditionalPersonalDetailsByUserId($idUser);

            return view(
                'order.index',
                [
                    'OrderProducts' => $orderProducts,
                    'personalDetails' => $defaultPersonalDetails,
                    'additionalPersonalDetails' => $additionalPersonalDetails
                ]
            );
        }
    }

    public function create()
    {
        $cartData = $this->cartService->dataCart();
        return view('order.create', $cartData);
    }

    public function show($orderProductId)
    {
        $orderData = $this->orderService->getOrdersByOrderProductId($orderProductId);

        $orderProductData = $orderData->first()->orderProduct;

        $subtotal = $orderProductData->subtotal;
        $shipping = $orderProductData->delivery;
        $payment = $orderProductData->payment;
        $promoCode = $orderProductData->promo_code;
        $total = $orderProductData->total;

        $personalDetailsId = $orderProductData->personal_details_id;
        $personalDetails = $this->personalDetailsService->getPersonalDetailByPersonalDetailsId($personalDetailsId);

        return view('order.show', [
            'products' => $orderData,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'payment' => $payment,
            'promo_code' => $promoCode,
            'total' => $total,
            'enableButtons' => false,
            'summary' => $personalDetails
        ]);
    }

    //store saveWithoutRegistration
    public function store(PersonalDetailsRequest $request)
    {
        $data = session('personalDetails');
        $data = $data->toArray();

        $idUser = auth()->user()->id ?? null;
        $data['user_id'] = $idUser;
        //if ($data) {
        $personalDetails = $this->personalDetailsService->store($request, $data);
        session()->forget('personalDetails');
        //}

        $cartData = $this->cartService->dataCart();

        $this->orderService->storeOrderBasedOnOrderProduct($idUser, $personalDetails, $cartData);
        session()->forget('cart');
        return redirect()->route(
            'products.index',
            ['category_products' => 'a']
        )->with('success', 'Order created successfully');
    }
}
