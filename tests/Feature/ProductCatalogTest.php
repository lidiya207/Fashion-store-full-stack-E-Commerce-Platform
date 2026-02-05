<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_lists_active_products(): void
    {
        $cat = Category::query()->create(['name' => 'Men', 'slug' => 'men']);

        $active = Product::query()->create([
            'category_id' => $cat->id,
            'name' => 'Active Tee',
            'slug' => 'active-tee',
            'price_cents' => 2500,
            'discount_cents' => 0,
            'is_featured' => false,
            'is_active' => true,
        ]);
        ProductVariant::query()->create([
            'product_id' => $active->id,
            'size' => 'M',
            'color' => 'Black',
            'stock' => 5,
        ]);

        Product::query()->create([
            'category_id' => $cat->id,
            'name' => 'Inactive Tee',
            'slug' => 'inactive-tee',
            'price_cents' => 2500,
            'discount_cents' => 0,
            'is_featured' => false,
            'is_active' => false,
        ]);

        $res = $this->getJson('/api/products');
        $res->assertOk();
        $this->assertCount(1, $res->json('data'));
        $res->assertJsonPath('data.0.slug', 'active-tee');
    }
}

