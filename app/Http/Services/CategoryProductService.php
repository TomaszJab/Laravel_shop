<?php

namespace App\Http\Services;

use App\Models\CategoryProduct;
use App\Http\Requests\CategoryProductRequest;

class CategoryProductService
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    // }

    public function getProductsByCategoryName(string $categoryName, ?string $sortOption)
    {
        $category_products = CategoryProduct::where('name_category_product', $categoryName)->firstOrFail();
        if ($sortOption) {
            $products = $category_products->products()->orderBy('name', $sortOption)->paginate(6);
        } else {
            $products = $category_products->products()->orderBy('favorite', 'desc')->paginate(6);
        }
        return $products;
    }

    public function getAllCategory()
    {
        return CategoryProduct::all();
    }

    public function getAllCategoryPaginate($paginiate)
    {
        return CategoryProduct::paginate($paginiate);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryProductRequest $request)
    {
        $request->validated();
        $data = $request->all();
        CategoryProduct::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryProduct $categoryProduct)
    {
        return $categoryProduct;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryProductRequest $request, CategoryProduct $categoryProduct)
    {
        $request->validated();
        $data = $request->all();
        $categoryProduct->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryProduct $categoryProduct)
    {
        $categoryProduct->delete();
    }
}
