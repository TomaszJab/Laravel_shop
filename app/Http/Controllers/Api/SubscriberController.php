<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $subscriber = $this->subscriberService->store($request);

        return response()->json([
            'subscriber' => new SubscriberResource($subscriber),
        ], 201);
    }
}
