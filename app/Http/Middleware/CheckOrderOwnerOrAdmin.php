<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\OrderProduct;

class CheckOrderOwnerOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $orderProductId = $request->route('orderProductId'); // lub 'orderProduct', jeśli model bound
        $orderProduct = OrderProduct::find($orderProductId);

        if (!$orderProduct) {
            abort(404, 'Order not found');
        }

        $user = $request->user();

        if ($user->id == $orderProduct->user_id || $user->role == 'admin') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
