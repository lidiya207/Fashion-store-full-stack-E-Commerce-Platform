<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->integer('per_page', 10);
        $perPage = max(1, min(50, $perPage));

        $orders = Order::query()
            ->where('user_id', auth()->id())
            ->with(['items', 'address'])
            ->orderByDesc('id')
            ->paginate($perPage);

        return OrderResource::collection($orders);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['items', 'address']);

        return OrderResource::make($order);
    }
}

