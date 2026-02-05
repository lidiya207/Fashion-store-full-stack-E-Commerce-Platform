<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Cart */
class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $items = [];
        
        if ($this->relationLoaded('items')) {
            $items = $this->items->map(function ($item) {
                $variant = $item->variant;
                $product = $variant?->product;

                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'variant' => $variant ? [
                        'id' => $variant->id,
                        'size' => $variant->size,
                        'color' => $variant->color,
                        'stock' => $variant->stock,
                    ] : null,
                    'product' => $product ? [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'price_cents' => $product->price_cents,
                        'discount_cents' => $product->discount_cents,
                        'images' => $product->images->map(function ($img) {
                            $url = $img->path;
                            // If path is a full URL, use it; otherwise, prepend storage path
                            if (filter_var($url, FILTER_VALIDATE_URL)) {
                                return [
                                    'id' => $img->id,
                                    'path' => $img->path,
                                    'url' => $url,
                                ];
                            }
                            return [
                                'id' => $img->id,
                                'path' => $img->path,
                                'url' => asset('storage/' . $img->path),
                            ];
                        })->toArray(),
                    ] : null,
                ];
            })->toArray();
        }

        return [
            'id' => $this->id,
            'items' => $items,
        ];
    }
}

