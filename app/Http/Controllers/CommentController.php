<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CommentService;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(
        CommentService $commentService
    ) {
        $this->commentService = $commentService;
    }

    public function store(CommentRequest $request, $productId)
    {
        $comment = $this->commentService->store($request, $productId);
        return response()->json($comment, 201);
    }
}
