<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PromoCodeService;
use App\Models\PromoCode;

class PromoCodeController extends Controller
{
    protected $promoCodeService;

    public function __construct(
        PromoCodeService $promoCodeService
    ) {
        $this->promoCodeService = $promoCodeService;
    }

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('promoCode.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->promoCodeService->store($request);

        return redirect()->route('orders.index')->with('success', 'Promo Code created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PromoCode $promoCode)
    {
        return view('promoCode.show', compact('promoCode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PromoCode $promoCode)
    {
        return view('promoCode.edit', compact('promoCode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PromoCode $promoCode)
    {
        $this->promoCodeService->update($request, $promoCode);

        return redirect()->route('orders.index')->with('success', 'Promo Code created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PromoCode $promoCode)
    {
        $this->promoCodeService->destroy($promoCode);

        return redirect()->route('orders.index')->with('success', 'Promo Code deleted successfully.');
    }

    public function checkPromo(Request $request) //get
    {
        $promoCode = $request->input('promo_code');
        $promo = $this->promoCodeService->checkPromo($promoCode);

        // Odpowiedź JSON
        // return response()->json(['success' => true]);
        if ($promo) {
            $cart = session()->get('cart', []);
            $cart['promo_code'] = '10';
            session()->put('cart', $cart);
            return response()->json(['success' => true, 'discount' => $cart['promo_code']]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
