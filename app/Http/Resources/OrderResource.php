<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Order */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user?->id,
                    'name' => $this->user?->name,
                    'email' => $this->user?->email,
                ];
            }),
            'status' => $this->status,
            'subtotal_cents' => $this->subtotal_cents,
            'discount_cents' => $this->discount_cents,
            'total_cents' => $this->total_cents,
            'address' => $this->whenLoaded('address', function () {
                return $this->address ? [
                    'id' => $this->address->id,
                    'label' => $this->address->label,
                    'full_name' => $this->address->full_name,
                    'phone' => $this->address->phone,
                    'line1' => $this->address->line1,
                    'line2' => $this->address->line2,
                    'city' => $this->address->city,
                    'state' => $this->address->state,
                    'postal_code' => $this->address->postal_code,
                    'country' => $this->address->country,
                ] : null;
            }),
            'items' => $this->whenLoaded('items', function () {
                return $this->items->map(fn ($i) => [
                    'id' => $i->id,
                    'product_id' => $i->product_id,
                    'product_variant_id' => $i->product_variant_id,
                    'name' => $i->name,
                    'size' => $i->size,
                    'color' => $i->color,
                    'unit_price_cents' => $i->unit_price_cents,
                    'unit_discount_cents' => $i->unit_discount_cents,
                    'quantity' => $i->quantity,
                    'line_total_cents' => $i->line_total_cents,
                ]);
            }),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}

