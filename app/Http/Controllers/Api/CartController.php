<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
// use App\Models\OrderProduct;
// use App\Models\Order;
// use App\Models\Product;
use App\Http\Services\OrderService;
use App\Http\Services\OrderProductService;
use App\Http\Services\PersonalDetailsService;
use App\Http\Services\ProductService;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Resources\OrderProductResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PersonalDetailsResource;
use App\Http\Resources\ProductResource;

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

    //http://127.0.0.1:8000/api/cart/buy
    public function buyWithoutRegistration()
    {
        $idUser = Auth::guard('sanctum')->user()->id ?? null;
        if ($idUser) {
            $defaultPersonalDetails = $this->personalDetailsService->getDefaultPersonalDetailsByUserId($idUser);
        } else {
            $defaultPersonalDetails = null;
        }

        return [
            'defaultPersonalDetails' => $defaultPersonalDetails ? PersonalDetailsResource::make($defaultPersonalDetails) : null
        ];
    }

    public function storeWithoutRegistration(PersonalDetailsRequest $request)
    {
        $personalDetails = $this->personalDetailsService->storeWithoutRegistration($request);

        return [
            'summary' => PersonalDetailsResource::make($personalDetails)
        ];
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

    public function updateDefaultPersonalDetails(Request $request)
    {
        $userId = Auth::guard('sanctum')->user()->id ?? null;
        //$userId = auth()->user()->id;

        $data = $request->except('_token');
        $data['user_id'] = $userId;

        $defaultPersonalDetails = $request->input('default_personal_details');
        if ($defaultPersonalDetails == "0") {
            $data['company_or_private_person'] = 'private_person';
        }

        $companyOrPrivatePerson = $data['company_or_private_person'];

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

        if ($companyOrPrivatePerson == 'private_person') {
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
