<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentService extends Controller
{
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
    public function store(CommentRequest $request, int $productId)
    {
        $request->validated();
        $product = Product::findOrFail($productId);
        $nameUser = auth()->user()->name;

        $comment = $product->comments()->create([
            'content' => $request->input('content'),
            'author' => $nameUser, //$request->input('author')
            'product_id' => $productId
        ]);

        return $comment;
    }

    public function getCommenstOrderByCreatedAt(Product $product, string $sortOption)
    {
        $comments = $product->comments()->orderBy('created_at', $sortOption)->get();
        return $comments;
    }

    /**
     * Display the specified resource.
     */
    // public function show(Comment $comment)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Comment $comment)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Comment $comment)
    // {
    //     //
    // }
}
