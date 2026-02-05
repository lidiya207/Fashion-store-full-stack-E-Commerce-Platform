<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_add_to_cart_and_checkout(): void
    {
        $customerRole = Role::query()->create(['name' => 'customer']);
        $user = User::query()->create([
            'role_id' => $customerRole->id,
            'name' => 'Customer',
            'email' => 'cust@example.com',
            'password' => bcrypt('password'),
        ]);

        $cat = Category::query()->create(['name' => 'Women', 'slug' => 'women']);
        $product = Product::query()->create([
            'category_id' => $cat->id,
            'name' => 'Dress',
            'slug' => 'dress',
            'price_cents' => 10000,
            'discount_cents' => 1000,
            'is_featured' => false,
            'is_active' => true,
        ]);
        $variant = ProductVariant::query()->create([
            'product_id' => $product->id,
            'size' => 'S',
            'color' => 'Red',
            'stock' => 3,
        ]);

        $address = Address::query()->create([
            'user_id' => $user->id,
            'full_name' => 'Customer',
            'line1' => '123 Main',
            'city' => 'Town',
            'country' => 'US',
            'is_default' => true,
        ]);

        $this->actingAs($user);

        $this->postJson('/api/cart/items', [
            'product_variant_id' => $variant->id,
            'quantity' => 2,
        ])->assertCreated();

        $checkout = $this->postJson('/api/checkout', [
            'address_id' => $address->id,
        ])->assertCreated();

        $checkout->assertJsonPath('order.items.0.quantity', 2);

        $variant->refresh();
        $this->assertSame(1, $variant->stock);
    }
}

