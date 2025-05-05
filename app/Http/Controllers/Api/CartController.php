<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\Product;
use App\Http\Services\OrderService;
use App\Http\Services\OrderProductService;
use App\Http\Services\PersonalDetailsService;
use App\Http\Services\ProductService;

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

        $subtotal = $orderProductData->subtotal;
        $shipping = $orderProductData->delivery;
        $payment = $orderProductData->payment;
        $promoCode = $orderProductData->promo_code;
        $total = $orderProductData->total;

        $personalDetailsId = $orderProductData->personal_details_id;
        $personalDetails = $this->personalDetailsService->getPersonalDetailByPersonalDetailsId($personalDetailsId);

        return response()->json([
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

    public function order()
    {
        $userIsAdmin = Auth::guard('sanctum')->user()->isAdmin();

        if ($userIsAdmin) {
            $products = $this->productService->getAllProductPaginate(8);
            $orderProducts = $this->orderProductService->getAllOrderProductPaginate(8);

            return response()->json([
                'orderProducts' => $orderProducts,
                'products' => $products
            ]);
        } else {
            $user = Auth::guard('sanctum')->user();
            $idUser = $user->id;
            $orderProducts = $this->orderProductService->getAllOrderProductPaginateByIdUser($idUser, 8);
            $defaultPersonalDetails = $this->personalDetailsService->getDefaultPersonalDetailsByUserId($idUser);
            $additionalPersonalDetails = $this->personalDetailsService->getAdditionalPersonalDetailsByUserId($idUser);

            return response()->json([
                'orderProducts' => $orderProducts,
                'personalDetails' => $defaultPersonalDetails,
                'additionalPersonalDetails' => $additionalPersonalDetails
            ]);
        }
    }

    //http://127.0.0.1:8000/api/cart/buy
    public function buyWithoutRegistration()
    {
        $idUser = Auth::guard('sanctum')->user()->id ?? null;
        if ($idUser) {
            $defaultPersonalDetails = $this->personalDetailsService->getDefaultPersonalDetailsByUserId($idUser);
        } else {
            $defaultPersonalDetails = null;
        }

        return response()->json([
            'defaultPersonalDetails' => $defaultPersonalDetails
        ]);
    }

    public function storeWithoutRegistration(Request $request)
    {
        $company_or_private_person = $request->input('company_or_private_person');

        if ($company_or_private_person == 'private_person') {
            $request->validate([
                'email' => 'required',
                'firstName' => 'required',
                'lastName' => 'required',
                'phone' => 'required',

                'street' => 'required',
                'house_number' => 'required',
                'zip_code' => 'required',
                'city' => 'required',

                'acceptance_of_the_regulations' => 'required'
            ]);
        } else {
            $request->validate([
                'email' => 'required',
                'firstName' => 'required',
                'lastName' => 'required',
                'phone' => 'required',

                'company_name' => 'required',
                'nip' => 'required',

                'street' => 'required',
                'house_number' => 'required',
                'zip_code' => 'required',
                'city' => 'required',

                'acceptance_of_the_regulations' => 'required'
            ]);
        }

        $summary = $request->except('_token');

        // Przekazanie danych do sesji
        session(['cart_summary' => $summary]);
        return redirect()->route('carts.summary');
        //->with('success','Product created successfully.');
    }

    public function saveWithoutRegistration(Request $request) ////////////
    {
        $dataPersonalDetails = $request->input('personal_details');
        //session('cart_summary');

        $idUser = Auth::guard('sanctum')->user()->id ?? null;
        //$idUser = auth()->user()->id ?? null;
        $dataPersonalDetails['user_id'] = $idUser;
        //if ($data) {
        $personalDetails = $this->personalDetailsService->store($dataPersonalDetails);
        //personalDetails::create($data);
        //to nie bedzie
        // session()->forget('cart_summary');
        //}

        //$cartData = $this->dataCart();
        $cartData = $request->input('cart_data');
        // if (!$cartData || !isset($cartData['products'])) {
        //     return response()->json(['error' => 'Invalid cart data'], 422);
        // }
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

        $orderProduct = OrderProduct::create($orderProduct);
        $order_product_id = $orderProduct->id;

        $order = array_map(function ($product, $productId) use ($order_product_id) {
            list($productId, $size) = explode('_', $productId);

            return [
                'product_id' => $productId,
                'order_product_id' => $order_product_id,
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
        Product::whereIn('id', $productIds)->increment('favorite');

        $order = Order::insert($order);
        //session()->forget('cart');

        //return redirect()->route('products.index',
        // ['category_products' => 'a'])->with('success', 'Order created successfully');
        return response()->json(['message' => 'Order created successfully'], 201);
    }

    public function updateDefaultPersonalDetails(Request $request)
    {
        $userId = Auth::guard('sanctum')->user()->id ?? null;
        //$userId = auth()->user()->id;

        $data = $request->except('_token');
        $data['user_id'] = $userId;

        $default_personal_details = $request->input('default_personal_details');
        if ($default_personal_details == "0") {
            $data['company_or_private_person'] = 'private_person';
        }

        $company_or_private_person = $data['company_or_private_person'];

        $rules = [
            'email' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'phone' => 'required',

            'street' => 'required',
            'house_number' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
        ];

        if ($request->has('acceptance_of_the_regulations')) {
            $rules['acceptance_of_the_regulations'] = 'required';
        } else {
            $data['acceptance_of_the_regulations'] = '-';
        }

        if ($company_or_private_person == 'private_person') {
        } else {
            $rules['company_name'] = 'required';
            $rules['nip'] = 'required';
        }

        try {
            $validatedData = $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }

        $personalDetails = $this->personalDetailsService->store($data);
        //PersonalDetails::create($data);

        return response()->json($personalDetails, 201);
        //return redirect()->back()->with('success', 'Personal details saved successfully.');
    }

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
