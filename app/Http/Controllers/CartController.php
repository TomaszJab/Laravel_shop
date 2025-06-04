<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Services\OrderService;
use App\Http\Services\OrderProductService;
use App\Http\Services\PersonalDetailsService;
use App\Http\Services\CartService;
use App\Http\Services\ProductService;

class CartController extends Controller
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

    public function create()
    {
        $cartData = $this->cartService->dataCart();
        return view('cart.index', $cartData);
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

    public function destroyAll() //ok
    {
        session()->forget('cart');
        return redirect()->back();
    }

    public function updateQuantity(Request $request) //ok
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

    public function updatePrice(Request $request) //
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

    public function storeAndRedirect($id, Request $request)
    {
        $this->store($id, $request);
        return redirect()->route('cart.create');
    }

    public function store($id, Request $request)
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

    public function show()//public function show(CartData) $cartData tutaj nie będzie :D
    {
        $cartData = $this->cartService->dataCart();
        $summary = session('personalDetails', []);

        return view('order.show', array_merge($cartData, ['summary' => $summary]));
    }
}
