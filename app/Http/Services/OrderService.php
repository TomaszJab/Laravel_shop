<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\PersonalDetails;
use Illuminate\Http\Request;

class OrderService extends Controller
{
    protected $orderProductService;
    protected $productService;

    public function __construct(
        OrderProductService $orderProductService,
        ProductService $productService
    ) {
        $this->orderProductService = $orderProductService;
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getOrdersByOrderProductId(int $order_product_id)
    {
        return Order::where('order_product_id', $order_product_id)->get();
    }

    public function storeOrderBasedOnOrderProduct(?int $idUser, PersonalDetails $personalDetails, array $cartData)
    {
        $orderProduct = [
            'user_id' => $idUser,
            'personal_details_id' => $personalDetails->id,
            'method_delivery' => $cartData['method_delivery'],
            'method_payment' => $cartData['method_payment'],
            'promo_code' => $cartData['promo_code'],
            'delivery' => $cartData['shipping'],
            'subtotal' => $cartData['subtotal'],
            'total' => $cartData['total'],
            'payment' => $cartData['payment']
        ];

        $orderProduct = $this->orderProductService->create($orderProduct);

        $orderProductId = $orderProduct->id;

        $order = array_map(function ($product, $productId) use ($orderProductId) {
            list($productId, $size) = explode('_', $productId);

            return [
                'product_id' => $productId,
                'order_product_id' => $orderProductId,
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'size' => $size,
                'category_products_id' => $product['category_products_id'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $cartData['products'], array_keys($cartData['products']));

        $productIds = array_keys($cartData['products']);
        $productIds = array_map(fn($id) => (int) explode('_', $id)[0], $productIds);
        $this->productService->increment($productIds, 'favorite');

        $this->insert($order);
    }

    public function insert(array $order)
    {
        return Order::insert($order);
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
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
