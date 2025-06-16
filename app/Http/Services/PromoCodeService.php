<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromoCode;

class PromoCodeService extends Controller
{
    public function getAllPromoCodePaginate($paginate)
    {
        return PromoCode::paginate($paginate);
    }

    public function checkPromo(string $promoCode)
    {
        $promoCode =  PromoCode::where('name', $promoCode)->first();
        return $promoCode;
    }
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //walidate
        $data = $request->all();
        PromoCode::create($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PromoCode $promoCode)
    {
        //walidate
        $data = $request->all();
        $promoCode->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();
    }
}
