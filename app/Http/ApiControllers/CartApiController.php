<?php

namespace App\Http\ApiControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use App\Models\personalDetails;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\Product;

use App\Http\Services\OrderService;
use App\Http\Services\OrderProductService;
use App\Http\Services\PersonalDetailsService;
use App\Http\Services\ProductService;

class CartApiController extends Controller
{
    protected $orderService;
    protected $orderProductService;
    protected $personalDetailsService;
    protected $productService;

    public function __construct(OrderService $orderService, OrderProductService $orderProductService, PersonalDetailsService $personalDetailsService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->orderProductService = $orderProductService;
        $this->personalDetailsService = $personalDetailsService;
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    //http://127.0.0.1:8000/api/cart/order/details/18
    public function details($order_product_id)
    {
        $orderData = $this->orderService->getOrdersByOrderProductId($order_product_id);
        //Order::where('order_product_id', $order_product_id) -> get();
        $orderProductData = $this->orderProductService->getOrderProductByOrderProductId($order_product_id);
        //OrderProduct::where('id', $order_product_id) -> first();

        $subtotal = $orderProductData -> subtotal;
        $shipping = $orderProductData -> delivery; 
        $payment = $orderProductData -> payment;
        $promo_code = $orderProductData -> promo_code;
        $total = $orderProductData -> total;

        $personal_details_id = $orderProductData -> personal_details_id;
        //get personalDetails details by personal_details_id
        $personalDetails = $this->personalDetailsService->getPersonalDetailByPersonalDetailsId($personal_details_id);
        //personalDetails::where('id', $orderProductData -> personal_details_id) -> first();
       
        return response() -> json(['products' => $orderData,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'payment' => $payment,
            'promo_code' => $promo_code,
            'total' => $total,
            'enableButtons' => false,
            'summary' => $personalDetails
        ]);
    }

    //http://127.0.0.1:8000/api/cart/order
    public function order()
    {
        //$userIsAdmin = auth()->user()->isAdmin();
        $userIsAdmin = Auth::guard('sanctum')->user()->isAdmin();

        if($userIsAdmin){
            $products = $this->productService->getAllProductPaginate(8);
            //Product::paginate(8);
            $OrderProducts = $this->orderProductService->getAllOrderProductPaginate(8);
            //OrderProduct::paginate(8);
            //return view('cart.order', ['OrderProducts' => $OrderProducts, 'products' => $products]);
            return response()->json([
                'OrderProducts' => $OrderProducts,
                'products' => $products
            ]);
        }else{
            $user = Auth::guard('sanctum')->user(); 
            $idUser = $user->id;
            $OrderProducts = $this->orderProductService->getAllOrderProductPaginateByIdUser($idUser, 8);
            //OrderProduct::where('user_id', $idUser)->paginate(8);
            $defaultPersonalDetails = $this->personalDetailsService->getDefaultPersonalDetailsByUserId($idUser);
            //personalDetails::where('user_id', $idUser)->where('default_personal_details', '1')->latest()->first();
            $additionalPersonalDetails = $this->personalDetailsService->getAdditionalPersonalDetailsByUserId($idUser);
            //personalDetails::where('user_id', $idUser)->where('default_personal_details', '0')->latest()->first();
            //return view('cart.order', ['OrderProducts' => $OrderProducts,'personalDetails'=>$defaultPersonalDetails,'additionalPersonalDetails'=>$additionalPersonalDetails]);
            return response()->json([
                'OrderProducts' => $OrderProducts,
                'personalDetails'=>$defaultPersonalDetails,
                'additionalPersonalDetails'=>$additionalPersonalDetails
            ]);
        }
    }

    //http://127.0.0.1:8000/api/cart/buy
    public function buyWithoutRegistration()
    {
        $idUser = Auth::guard('sanctum')->user()->id ?? null;
        //$idUser = auth()->user()->id ?? null;
        if($idUser){
            $defaultPersonalDetails = $this->personalDetailsService->getAdditionalPersonalDetailsByUserId($idUser);
            //personalDetails::where('user_id', $idUser)->where('default_personal_details', '1')->latest()->first();
            //return view('cart.buyWithoutRegistration',['defaultPersonalDetails' => $defaultPersonalDetails]);
        }else{
            $defaultPersonalDetails = null;
            //return view('cart.buyWithoutRegistration');
        }

        return response()->json([
            'defaultPersonalDetails' => $defaultPersonalDetails
        ]);
    }

    public function savewithoutregistration(Request $request)////////////
    {
        $data = $request->all();
        //session('cart_summary');

        $idUser = Auth::guard('sanctum')->user()->id ?? null;
        //$idUser = auth()->user()->id ?? null;
        $data['user_id'] = $idUser;
        //if ($data) {
            $personalDetails = $this->personalDetailsService->store($data);
            //personalDetails::create($data);
            session()->forget('cart_summary');
        //}

        $cartData = $this->dataCart();

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
        $order_product_id = $orderProduct -> id;

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
        session()->forget('cart');

        return redirect()->route('products.index', ['category_products' => 'a'])->with('success', 'Order created successfully');
    }

    // POST http://127.0.0.1:8000/api/cart/updateDefaultPersonalDetails
    // {
    //     "email": "test@example.com",
    //     "firstName": "Jan",
    //     "lastName": "Kowalski",
    //     "phone": "123456789",
    //     "street": "Warszawska",
    //     "house_number": "10",
    //     "zip_code": "00-001",
    //     "company_or_private_person": "company",
    //     "company_name":"s",
    //     "nip":"22",
    //     "city": "Warszawa",
    //     "default_personal_details": "1",
    //     "acceptance_of_the_regulations": "yes"
    // }
    public function updateDefaultPersonalDetails(Request $request){
        $userId = Auth::guard('sanctum')->user()->id ?? null;
        //$userId = auth()->user()->id;

        $data = $request->except('_token');
        $data['user_id'] = $userId;

        $default_personal_details = $request->input('default_personal_details');
        if($default_personal_details=="0"){
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
            
        }else{
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

        return response() -> json($personalDetails, 201);
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
