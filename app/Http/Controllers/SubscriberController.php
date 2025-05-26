<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\SubscriberService;
use App\Http\Requests\SubscriberRequest;
use App\Http\Resources\SubscriberResource;

class SubscriberController extends Controller
{
    protected $subscriberService;

    public function __construct(
        SubscriberService $subscriberService
    ) {
        $this->subscriberService = $subscriberService;
    }

    public function store(SubscriberRequest $request)
    {
        $this->subscriberService->store($request);

        return redirect()
            ->route('products.index', ['category_products' => 'a'])
            ->with('success', 'You are a subscriber!');
    }
}
