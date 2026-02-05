<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class CartService
{
    public function getOrCreateForUser(User $user): Cart
    {
        /** @var Cart $cart */
        $cart = Cart::query()->firstOrCreate(['user_id' => $user->id]);

        return $cart;
    }

    public function addItem(User $user, int $variantId, int $quantity): Cart
    {
        $cart = $this->getOrCreateForUser($user);

        /** @var ProductVariant|null $variant */
        $variant = ProductVariant::query()->with('product')->find($variantId);
        if (!$variant || !$variant->product || !$variant->product->is_active) {
            throw ValidationException::withMessages([
                'product_variant_id' => ['Variant not available.'],
            ]);
        }

        if ($variant->stock < $quantity) {
            throw ValidationException::withMessages([
                'quantity' => ['Requested quantity exceeds available stock.'],
            ]);
        }

        /** @var CartItem $item */
        $item = CartItem::query()->firstOrNew([
            'cart_id' => $cart->id,
            'product_variant_id' => $variantId,
        ]);

        $newQty = ($item->exists ? $item->quantity : 0) + $quantity;
        if ($variant->stock < $newQty) {
            throw ValidationException::withMessages([
                'quantity' => ['Requested quantity exceeds available stock.'],
            ]);
        }

        $item->quantity = $newQty;
        $item->save();

        return $cart->fresh();
    }

    public function updateItemQuantity(CartItem $cartItem, int $quantity): Cart
    {
        $variant = $cartItem->variant;
        if ($variant && $variant->stock < $quantity) {
            throw ValidationException::withMessages([
                'quantity' => ['Requested quantity exceeds available stock.'],
            ]);
        }

        $cartItem->update(['quantity' => $quantity]);

        return $cartItem->cart->fresh();
    }

    public function removeItem(CartItem $cartItem): Cart
    {
        $cart = $cartItem->cart;
        $cartItem->delete();

        return $cart->fresh();
    }

    public function assertOwnsCartItem(User $user, CartItem $cartItem): void
    {
        if ($cartItem->cart?->user_id !== $user->id) {
            abort(403, 'Forbidden.');
        }
    }
}

