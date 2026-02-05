<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderStatusUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->integer('per_page', 20);
        $perPage = max(1, min(100, $perPage));

        $query = Order::query()->with(['items', 'address', 'user']);

        if ($request->filled('status')) {
            $query->where('status', (string) $request->query('status'));
        }

        return OrderResource::collection(
            $query->orderByDesc('id')->paginate($perPage)
        );
    }

    public function show(Order $order)
    {
        $order->load(['items', 'address', 'user']);

        return OrderResource::make($order);
    }

    public function updateStatus(OrderStatusUpdateRequest $request, Order $order): JsonResponse
    {
        $order->update([
            'status' => $request->validated('status'),
        ]);

        return response()->json([
            'order' => OrderResource::make($order->load(['items', 'address', 'user'])),
        ]);
    }
}

