<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\File;

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

    public function getAllProductPaginate($paginate)
    {
        return Product::paginate($paginate);
    }

    public function getProductOrderByFavorite(string $sortOption)
    {
        return Product::orderBy('favorite', $sortOption)->firstOrFail();
    }

    public function getProductById(int $id)
    {
        $product = Product::findOrFail($id);
        return $product;
    }

    /**
     * Store a newly created resource in storage.
     */
    // test
    public function store(ProductRequest $request)
    {
        //walidacja
        $request->validated();

        $data = $request->except('_token');
        if ($image = $request->file('image')) {
            $destinationPath = 'images/product/main';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $path = public_path() . '/images/product/main';
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            $image->move($destinationPath, $profileImage);
            $data['image'] = "$profileImage";
        }

        $product = Product::create($data);
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
    public function update(ProductRequest $request, Product $product)
    {
        $request->validated();

        $data = $request->all();
        if ($image = $request->file('image')) {
            $destinationPath = 'images/product/main';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $path = public_path() . '/images/product/main';
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            $image->move($destinationPath, $profileImage);
            $data['image'] = "$profileImage";
        }

        $product->update($data);
        return $product->fresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    // test
    public function destroy(Product $product)
    {
        $product->delete();
    }

    /**
     * @param int[] $productIds
     */
    public function increment(array $productIds, string $increment)
    {
        Product::whereIn('id', $productIds)->increment($increment);
    }
}
