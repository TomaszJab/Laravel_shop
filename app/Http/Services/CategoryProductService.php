<?php

namespace App\Http\Services;
use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryProductService extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getProductsByCategoryName(string $categoryName, ?string $sortOption){
        $category_products = CategoryProduct::where('name_category_product', $categoryName)->firstOrFail();
        if($sortOption){
            $products = $category_products->products()->orderBy('name', $sortOption)->paginate(6);
        }else{
            $products = $category_products->products()->orderBy('favorite', 'desc')->paginate(6);
        }
        return $products;
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
    public function show(CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryProduct $categoryProduct)
    {
        //
    }
}
