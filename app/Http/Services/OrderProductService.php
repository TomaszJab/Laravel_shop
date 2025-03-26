<?php

namespace App\Http\Services;
use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderProductService extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getAllOrderProductPaginate(int $paginate){
        return OrderProduct::paginate($paginate);
    }

    public function getAllOrderProductPaginateByIdUser(int $idUser, int $paginate){
        return OrderProduct::where('user_id', $idUser)->paginate($paginate);
    }

    public function getOrderProductByOrderProductId(int $order_product_id){
        return OrderProduct::where('id', $order_product_id) -> first();
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
    public function show(OrderProduct $orderProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderProduct $orderProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderProduct $orderProduct)
    {
        //
    }
}
