<?php

namespace App\Http\ApiControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\personalDetails;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\Product;

class CartApiController extends Controller
{
    protected $orderService;
    protected $orderProductService;

    public function __construct(OrderService $orderService, OrderProductService $orderProductService)
    {
        $this->orderService = $orderService;
        $this->orderProductService = $orderProductService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function details($order_product_id)
    {
        //get order by order_product_id
        $orderData = $this->orderService->getOrdersByOrderProductId($order_product_id);
        //Order::where('order_product_id', $order_product_id) -> get();
        //get personal details by id
        $orderProductData = $this->orderProductService->getOrderProductByOrderProductId($order_product_id);
        //OrderProduct::where('id', $order_product_id) -> first();

        $subtotal = $orderProductData -> subtotal;
        $shipping = $orderProductData -> delivery; 
        $payment = $orderProductData -> payment;
        $promo_code = $orderProductData -> promo_code;
        $total = $orderProductData -> total;

        $personal_details_id = $orderProductData -> personal_details_id;
        //get personalDetails details by personal_details_id
        $personalDetails = personalDetails::where('id', $orderProductData -> personal_details_id) -> first();
       
        return view('cart.summary', ['products' => $orderData,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'payment' => $payment,
            'promo_code' => $promo_code,
            'total' => $total,
            'enableButtons' => false,
            'summary' => $personalDetails
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
