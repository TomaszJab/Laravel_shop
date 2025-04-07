<?php

namespace App\Http\Services;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductService extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //index test
    public function getAllProducts()
    {
        return Product::all();
    }

    public function getAllProductPaginate($paginate){
        return Product::paginate($paginate);
    }

    public function getProductOrderByFavorite(string $sortOption){
        return Product::orderBy('favorite', $sortOption)->firstOrFail();
    }

    /**
     * Store a newly created resource in storage.
     */
    // test
    public function store(ProductRequest $request)
    {
        //walidacja
        // $request->validate([
        //     'name' => 'required',
        //     'price' => 'required',
        //     'detail' => 'required',
        //     'category_products_id' => 'required'
        // ]);
        $request->validated();

        $product = Product::create($request -> except('_token'));
        return $product;
    }

    /**
     * Display the specified resource.
     */
    // test
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    // test
    public function update(Request $request, Product $product)
    {
        //walidacja
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    // test
    public function destroy(Product $product)//
    {
        $product->delete();
    }
}
