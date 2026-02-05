<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\OrderResource;
use App\Services\CheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function checkout(CheckoutRequest $request, CheckoutService $service): JsonResponse
    {
        try {
            $order = $service->checkout(
                auth()->user(),
                (int) $request->validated('address_id')
            );
        } catch (ValidationException $e) {
            throw $e;
        } catch (\RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 409);
        }

        return response()->json([
            'order' => OrderResource::make($order->load(['items', 'address'])),
        ], 201);
    }
}

