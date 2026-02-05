<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function show(CartService $cartService): JsonResponse
    {
        $cart = $cartService->getOrCreateForUser(auth()->user());

        return response()->json([
            'data' => CartResource::make($cart->load(['items.variant.product.images'])),
        ]);
    }

    public function addItem(AddCartItemRequest $request, CartService $cartService): JsonResponse
    {
        $cart = $cartService->addItem(
            auth()->user(),
            (int) $request->validated('product_variant_id'),
            (int) $request->validated('quantity')
        );

        return response()->json([
            'cart' => CartResource::make($cart->load(['items.variant.product.images'])),
        ], 201);
    }

    public function updateItem(UpdateCartItemRequest $request, CartItem $cartItem, CartService $cartService): JsonResponse
    {
        $cartService->assertOwnsCartItem(auth()->user(), $cartItem);

        $cart = $cartService->updateItemQuantity($cartItem, (int) $request->validated('quantity'));

        return response()->json([
            'cart' => CartResource::make($cart->load(['items.variant.product.images'])),
        ]);
    }

    public function removeItem(CartItem $cartItem, CartService $cartService): JsonResponse
    {
        $cartService->assertOwnsCartItem(auth()->user(), $cartItem);

        $cart = $cartService->removeItem($cartItem);

        return response()->json([
            'cart' => CartResource::make($cart->load(['items.variant.product.images'])),
        ]);
    }
}

