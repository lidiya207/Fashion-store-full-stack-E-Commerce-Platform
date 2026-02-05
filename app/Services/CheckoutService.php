<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function checkout(User $user, int $addressId): Order
    {
        /** @var Address|null $address */
        $address = Address::query()
            ->where('user_id', $user->id)
            ->where('id', $addressId)
            ->first();

        if (!$address) {
            throw ValidationException::withMessages([
                'address_id' => ['Invalid address.'],
            ]);
        }

        /** @var Cart $cart */
        $cart = Cart::query()
            ->firstOrCreate(['user_id' => $user->id]);

        $cart->load(['items.variant.product']);

        if ($cart->items->isEmpty()) {
            throw new \RuntimeException('Cart is empty.');
        }

        return DB::transaction(function () use ($user, $address, $cart) {
            $subtotal = 0;
            $discount = 0;

            /** @var Order $order */
            $order = Order::query()->create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'status' => 'pending',
                'subtotal_cents' => 0,
                'discount_cents' => 0,
                'total_cents' => 0,
            ]);

            foreach ($cart->items as $cartItem) {
                $variant = $cartItem->variant;
                $product = $variant?->product;

                if (!$variant || !$product || !$product->is_active) {
                    throw new \RuntimeException('One or more items are no longer available.');
                }

                // Decrement stock safely (no negative stock)
                $updated = ProductVariant::query()
                    ->where('id', $variant->id)
                    ->where('stock', '>=', $cartItem->quantity)
                    ->decrement('stock', $cartItem->quantity);

                if ($updated !== 1) {
                    throw new \RuntimeException("Insufficient stock for {$product->name} ({$variant->size}/{$variant->color}).");
                }

                $unitPrice = (int) $product->price_cents;
                $unitDiscount = (int) min($product->discount_cents, $unitPrice);
                $lineTotal = ($unitPrice - $unitDiscount) * (int) $cartItem->quantity;

                $subtotal += $unitPrice * (int) $cartItem->quantity;
                $discount += $unitDiscount * (int) $cartItem->quantity;

                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_variant_id' => $variant->id,
                    'name' => $product->name,
                    'size' => $variant->size,
                    'color' => $variant->color,
                    'unit_price_cents' => $unitPrice,
                    'unit_discount_cents' => $unitDiscount,
                    'quantity' => (int) $cartItem->quantity,
                    'line_total_cents' => $lineTotal,
                ]);
            }

            $total = max(0, $subtotal - $discount);
            $order->update([
                'subtotal_cents' => $subtotal,
                'discount_cents' => $discount,
                'total_cents' => $total,
            ]);

            // Clear cart
            $cart->items()->delete();

            return $order;
        });
    }
}

