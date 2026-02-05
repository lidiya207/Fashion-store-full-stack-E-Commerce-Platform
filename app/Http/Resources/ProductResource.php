<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Product */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price_cents' => $this->price_cents,
            'price' => $this->price, // Accessor for convenience
            'discount_cents' => $this->discount_cents,
            'is_featured' => (bool) $this->is_featured,
            'is_active' => (bool) $this->is_active,
            'images' => $this->whenLoaded('images', function () {
                return $this->images->map(function ($img) {
                    // If path is already a full URL, use it; otherwise convert to storage URL
                    $url = $img->path;
                    if (!filter_var($img->path, FILTER_VALIDATE_URL)) {
                        // Local file path - convert to public URL
                        $url = str_starts_with($img->path, 'storage/') 
                            ? asset($img->path) 
                            : asset('storage/' . $img->path);
                    }
                    
                    return [
                        'id' => $img->id,
                        'path' => $img->path,
                        'url' => $url,
                        'sort_order' => $img->sort_order,
                    ];
                });
            }),
            'variants' => $this->whenLoaded('variants', function () {
                return $this->variants->map(fn ($v) => [
                    'id' => $v->id,
                    'size' => $v->size,
                    'color' => $v->color,
                    'stock' => $v->stock,
                ]);
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}

