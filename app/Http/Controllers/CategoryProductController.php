<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Http\Services\CategoryProductService;
use App\Http\Requests\CategoryProductRequest;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    protected $categoryProductService;

    public function __construct(CategoryProductService $categoryProductService)
    {
        $this->categoryProductService = $categoryProductService;
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
        return view('categoryProduct.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryProductRequest $request)
    {
        $this->categoryProductService->store($request);

        return redirect()->route('order.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryProduct $categoryProduct)
    {
        $categoryProduct = $this->categoryProductService->show($categoryProduct);

        return view('categoryProduct.create', $categoryProduct);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryProduct $categoryProduct)
    {
        return view('categoryProduct.edit', $categoryProduct);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryProductRequest $request, CategoryProduct $categoryProduct)
    {
        $categoryProduct = $this->categoryProductService->update($request, $categoryProduct);

        return redirect()->route('order.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryProduct $categoryProduct)
    {
        $this->categoryProductService->destroy($categoryProduct);

        return redirect()->route('order.index')->with('success', 'Category deleted successfully.');
    }
}
