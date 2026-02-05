<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductAdminService
{
    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $images = $data['images'] ?? [];
            $variants = $data['variants'] ?? [];
            unset($data['images'], $data['variants']);

            /** @var Product $product */
            $product = Product::query()->create($data);

            if (!empty($images)) {
                $product->images()->createMany($images);
            }

            $product->variants()->createMany($variants);

            return $product;
        });
    }

    public function update(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            $images = $data['images'] ?? null;
            $variants = $data['variants'] ?? null;
            unset($data['images'], $data['variants']);

            if (!empty($data)) {
                $product->update($data);
            }

            if (is_array($images)) {
                $product->images()->delete();
                if (!empty($images)) {
                    $product->images()->createMany($images);
                }
            }

            if (is_array($variants)) {
                $product->variants()->delete();
                $product->variants()->createMany($variants);
            }

            return $product;
        });
    }
}

