<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\PersonalDetails;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\Product;
use App\Http\Services\OrderService;
use App\Http\Services\OrderProductService;
use App\Http\Services\PersonalDetailsService;
use App\Http\Services\ProductService;
use App\Http\Requests\PersonalDetailsRequest;

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
    //widok karty///create
    public function index()
    {
        $cartData = $this->dataCart();
        return view('cart.index', $cartData);
    }
    //szczegoly zamowienia jednego zamowienia//show
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

        return view('cart.summary', [
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

    public function destroy($id)
    {
        if ($id) {
            $cart = session()->get('cart');

            if (isset($cart[$id])) {
                $products = array_filter($cart, 'is_array');
                $keys = array_keys($products);
                if (count($products) >= 2) {
                    $secondProductId = $keys[1];
                } else {
                    $secondProductId = $keys[0];
                }

                unset($cart[$id]);

                if (count($products) >= 2) {
                    session()->put('cart', $cart);
                    $subtotal = collect($products)->sum(fn($item) => $item['price'] * $item['quantity']);

                    if (count($products) == 1) {
                        $reload = true;
                    } else {
                        $reload = false;
                    }

                    return response()->json([
                        'success' => true,
                        'reload' => $reload,
                        'new_subtotal' => $subtotal,
                        'secondProductId' => $secondProductId,
                        'message' => 'Produkt został usunięty z koszyka.'
                    ]);
                } else {
                    session()->forget('cart');
                    //return view('cart.index');
                }
            }
            //session()->flash('success', 'Product removed successfully');
        } else {
            //session()->flash('success', 'Product not removed successfully');
        }
        return response()->json([
            'success' => true,
            'reload' => true,
            'new_subtotal' => 0,
            'secondProductId' => $secondProductId,
            'message' => 'Produkt został usunięty z koszyka.'
        ]);
    }

    public function delete() //ok
    {
        session()->forget('cart');
        return redirect()->back();
    }

    public function changeQuantity(Request $request) //ok
    {
        $action = $request->input("action");
        $product_id = $request->input("product_id");
        $cart = session()->get('cart', []);

        if (!isset($cart[$product_id])) {
            return response()->json(['success' => false, 'message' => 'Produkt nie znaleziony w koszyku.']);
            //return redirect()->back()->with('error', 'Produkt nie znaleziony w koszyku.');
        }

        if ($action == "decrease") {
            if ($cart[$product_id]['quantity'] > 1) {
                $cart[$product_id]['quantity'] -= 1;
            }
        } elseif ($action == "increase") {
            $cart[$product_id]['quantity'] += 1;
        }

        $products = array_filter($cart, 'is_array');
        $subtotal = number_format(collect($products)->sum(fn($item) => $item['price'] * $item['quantity']), 2);

        $subtotalProduct = number_format($cart[$product_id]['price'] * $cart[$product_id]['quantity'], 2);
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'new_quantity' => $cart[$product_id]['quantity'],
            'new_subtotal' => $subtotal,
            'new_subtotalProduct' => $subtotalProduct
        ]);

        //return redirect()->back();
    }

    public function changePrice(Request $request) //
    {
        $price = str_replace('$', '', $request->input("price"));
        $method = $request->input("method");
        $change = $request->input("change");

        $cart = session()->get('cart', []);

        if ($change == "Price") {
            $cart['delivery'] = $price;
            $cart['method_delivery'] = $method;
        } elseif ($change == "Payment") {
            $cart['payment'] = $price;
            $cart['method_payment'] = $method;
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function delivery() //ok
    {
        $cartData = $this->dataCart();
        return view('cart.delivery', $cartData);
    }
    //widok po zalogowaniu
    public function order()
    {
        $userIsAdmin = auth()->user()->isAdmin();

        if ($userIsAdmin) {
            $products = $this->productService->getAllProductPaginate(8);
            $orderProducts = $this->orderProductService->getAllOrderProductPaginate(8);

            return view('cart.order', ['OrderProducts' => $orderProducts, 'products' => $products]);
        } else {
            $idUser = auth()->user()->id;

            $orderProducts = $this->orderProductService->getAllOrderProductPaginateByIdUser($idUser, 8);
            $defaultPersonalDetails = $this->personalDetailsService->getDefaultPersonalDetailsByUserId($idUser);
            $additionalPersonalDetails = $this->personalDetailsService->getAdditionalPersonalDetailsByUserId($idUser);

            return view(
                'cart.order',
                [
                    'OrderProducts' => $orderProducts,
                    'personalDetails' => $defaultPersonalDetails,
                    'additionalPersonalDetails' => $additionalPersonalDetails
                ]
            );
        }
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

    //store
    public function saveWithoutRegistration(PersonalDetailsRequest $request)
    {
        $data = session('cart_summary');

        $idUser = auth()->user()->id ?? null;
        $data['user_id'] = $idUser;
        //if ($data) {
        $personalDetails = $this->personalDetailsService->store($request, $data);//PersonalDetails::create($data);;
        session()->forget('cart_summary');
        //}

        $cartData = $this->dataCart();

        $this->orderService->storeOrderBasedOnOrderProduct($idUser, $personalDetails, $cartData);
        // $orderProduct = [
        //     'user_id' => $idUser,
        //     'personal_details_id' => $personalDetails->id,
        //     'method_delivery' => $cartData['method_delivery'],
        //     'method_payment' => $cartData['method_payment'],
        //     'promo_code' => $cartData['promo_code'],
        //     'delivery' => $cartData['shipping'],
        //     'subtotal' => $cartData['subtotal'],
        //     'total' => $cartData['total'],
        //     'payment' => $cartData['payment']
        // ];

        // $orderProduct = OrderProduct::create($orderProduct);//$this->orderService->storeOrderBasedOnOrderProduct($idUser, $personalDetails, $cartData);
        // $orderProductId = $orderProduct->id;

        // $order = array_map(function ($product, $productId) use ($orderProductId) {
        //     list($productId, $size) = explode('_', $productId);

        //     return [
        //         'product_id' => $productId,
        //         'order_product_id' => $orderProductId,
        //         'name' => $product['name'],
        //         'quantity' => $product['quantity'],
        //         'price' => $product['price'],
        //         'size' => $size,
        //         'category_products_id' => $product['category_products_id'],
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ];
        // }, $cartData['products'], array_keys($cartData['products']));

        // $productIds = array_keys($cartData['products']);
        // $productIds = array_map(fn($id) => (int) explode('_', $id)[0], $productIds);
        // Product::whereIn('id', $productIds)->increment('favorite');////////////////////////

        // Order::insert($order);/////////////////
        // session()->forget('cart');

        return redirect()->route(
            'products.index',
            ['category_products' => 'a']
        )->with('success', 'Order created successfully');
    }

    public function summary()
    {
        $cartData = $this->dataCart();
        $summary = session('cart_summary', []);

        return view('cart.summary', array_merge($cartData, ['summary' => $summary]));
    }

    private function dataCart()
    {
        $cart = session('cart');

        if ($cart) {
            $products = array_filter($cart, 'is_array'); // Pobierz tylko produkty
            $subtotal = number_format(collect($products)->sum(fn($item) => $item['price'] * $item['quantity']), 2);
            $shipping = $cart['delivery'];
            $payment = $cart['payment'];

            $total = number_format($subtotal + $shipping + $payment, 2);
            if ($cart['promo_code'] <> '') {
                $total = number_format($total - ($total * $cart['promo_code']) / 100, 2);
            }

            $method_delivery = $cart['method_delivery'];
            $method_payment = $cart['method_payment'];
            $promo_code = $cart['promo_code'];

            return compact(
                'cart',
                'products',
                'subtotal',
                'shipping',
                'payment',
                'total',
                'promo_code',
                'method_delivery',
                'method_payment'
            );
        }

        return compact(
            'cart'
        );
    }
}
