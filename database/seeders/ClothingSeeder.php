<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClothingSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $men = Category::firstOrCreate(
            ['name' => 'Men'],
            ['slug' => Str::slug('Men')]
        );
        $women = Category::firstOrCreate(
            ['name' => 'Women'],
            ['slug' => Str::slug('Women')]
        );
        $kids = Category::firstOrCreate(
            ['name' => 'Kids'],
            ['slug' => Str::slug('Kids')]
        );
        $accessories = Category::firstOrCreate(
            ['name' => 'Accessories'],
            ['slug' => Str::slug('Accessories')]
        );

        $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
        $colors = ['Black', 'White', 'Navy', 'Gray', 'Red', 'Blue', 'Green', 'Beige', 'Brown', 'Pink'];

        // Men's Products
        $products = [
            [
                'category' => $men,
                'name' => 'Classic White T-Shirt',
                'description' => 'Comfortable cotton t-shirt perfect for everyday wear. Soft fabric and classic fit.',
                'price_cents' => 2999,
                'discount_cents' => 0,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&h=800&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $men,
                'name' => 'Slim Fit Jeans',
                'description' => 'Modern slim fit jeans with stretch for comfort. Perfect for casual and smart casual looks.',
                'price_cents' => 7999,
                'discount_cents' => 999,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&h=800&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $men,
                'name' => 'Cotton Polo Shirt',
                'description' => 'Premium cotton polo shirt with classic collar. Versatile for work or leisure.',
                'price_cents' => 4999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $men,
                'name' => 'Hooded Sweatshirt',
                'description' => 'Cozy hooded sweatshirt with front pocket. Perfect for cool weather.',
                'price_cents' => 5999,
                'discount_cents' => 0,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&h=800&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1556821843-0a3200a2a0e7?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $men,
                'name' => 'Chino Pants',
                'description' => 'Classic chino pants in versatile colors. Smart casual essential.',
                'price_cents' => 6999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $men,
                'name' => 'Denim Jacket',
                'description' => 'Classic denim jacket with timeless style. Perfect for layering.',
                'price_cents' => 8999,
                'discount_cents' => 1499,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $men,
                'name' => 'Oxford Button-Down Shirt',
                'description' => 'Crisp cotton oxford shirt. Perfect for business casual or smart casual.',
                'price_cents' => 5999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1594938291221-94f313afa0f4?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $men,
                'name' => 'Cargo Shorts',
                'description' => 'Comfortable cargo shorts with multiple pockets. Great for outdoor activities.',
                'price_cents' => 4999,
                'discount_cents' => 499,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $men,
                'name' => 'V-Neck Sweater',
                'description' => 'Soft knit sweater with V-neck. Perfect for layering in cooler weather.',
                'price_cents' => 6999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $men,
                'name' => 'Track Pants',
                'description' => 'Comfortable track pants with elastic waistband. Perfect for workouts or casual wear.',
                'price_cents' => 4499,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=800&h=800&fit=crop&q=80',
                ],
            ],

            // Women's Products
            [
                'category' => $women,
                'name' => 'Floral Summer Dress',
                'description' => 'Beautiful floral print dress perfect for summer. Lightweight and comfortable.',
                'price_cents' => 8999,
                'discount_cents' => 1499,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=800&h=800&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1566479179817-2785c0e7e89f?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $women,
                'name' => 'High-Waisted Jeans',
                'description' => 'Flattering high-waisted jeans with perfect fit. Stretch denim for comfort.',
                'price_cents' => 7999,
                'discount_cents' => 0,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=800&h=800&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $women,
                'name' => 'Silk Blouse',
                'description' => 'Elegant silk blouse for office or evening. Premium quality fabric.',
                'price_cents' => 9999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $women,
                'name' => 'Knit Cardigan',
                'description' => 'Soft knit cardigan perfect for layering. Cozy and stylish.',
                'price_cents' => 6999,
                'discount_cents' => 999,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $women,
                'name' => 'Midi Skirt',
                'description' => 'Elegant midi skirt in versatile colors. Perfect for office or casual wear.',
                'price_cents' => 5999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1594633313593-bab3825d0caf?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $women,
                'name' => 'Wrap Dress',
                'description' => 'Flattering wrap dress that suits all body types. Versatile and elegant.',
                'price_cents' => 8499,
                'discount_cents' => 999,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1566479179817-2785c0e7e89f?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $women,
                'name' => 'Wide-Leg Trousers',
                'description' => 'Comfortable wide-leg trousers with elegant drape. Perfect for office wear.',
                'price_cents' => 7499,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1594633313593-bab3825d0caf?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $women,
                'name' => 'Crop Top',
                'description' => 'Trendy crop top in various colors. Perfect for casual summer outfits.',
                'price_cents' => 3499,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $women,
                'name' => 'Maxi Dress',
                'description' => 'Elegant maxi dress perfect for special occasions. Flowing and comfortable.',
                'price_cents' => 9999,
                'discount_cents' => 1999,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $women,
                'name' => 'Blazer',
                'description' => 'Classic blazer for professional or smart casual looks. Tailored fit.',
                'price_cents' => 10999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1594938291221-94f313afa0f4?w=800&h=800&fit=crop&q=80',
                ],
            ],

            // Kids' Products
            [
                'category' => $kids,
                'name' => 'Kids T-Shirt Set',
                'description' => 'Comfortable cotton t-shirt set for kids. Fun colors and durable fabric.',
                'price_cents' => 2499,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $kids,
                'name' => 'Kids Denim Jeans',
                'description' => 'Durable kids jeans with adjustable waist. Perfect for active play.',
                'price_cents' => 3999,
                'discount_cents' => 499,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $kids,
                'name' => 'Kids Hoodie',
                'description' => 'Warm and cozy hoodie for kids. Soft fabric and fun designs.',
                'price_cents' => 3499,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $kids,
                'name' => 'Kids Summer Dress',
                'description' => 'Colorful summer dress for kids. Lightweight and fun patterns.',
                'price_cents' => 2999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $kids,
                'name' => 'Kids Leggings',
                'description' => 'Comfortable leggings for active kids. Stretch fabric and fun colors.',
                'price_cents' => 1999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=800&h=800&fit=crop&q=80',
                ],
            ],

            // Accessories
            [
                'category' => $accessories,
                'name' => 'Leather Belt',
                'description' => 'Classic leather belt with adjustable buckle. Timeless style.',
                'price_cents' => 3999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1624222247344-550fb60583fd?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $accessories,
                'name' => 'Wool Scarf',
                'description' => 'Warm wool scarf for winter. Soft and stylish in multiple colors.',
                'price_cents' => 2999,
                'discount_cents' => 499,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $accessories,
                'name' => 'Baseball Cap',
                'description' => 'Classic baseball cap with adjustable strap. Perfect for sunny days.',
                'price_cents' => 1999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $accessories,
                'name' => 'Leather Wallet',
                'description' => 'Slim leather wallet with card slots. Premium quality.',
                'price_cents' => 4999,
                'discount_cents' => 999,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1624222247344-550fb60583fd?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $accessories,
                'name' => 'Sunglasses',
                'description' => 'Stylish sunglasses with UV protection. Multiple frame styles.',
                'price_cents' => 5999,
                'discount_cents' => 0,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $accessories,
                'name' => 'Canvas Tote Bag',
                'description' => 'Spacious canvas tote bag. Perfect for shopping or daily use.',
                'price_cents' => 2499,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=800&h=800&fit=crop&q=80',
                ],
            ],

            // Additional 10 Products
            [
                'category' => $men,
                'name' => 'Bomber Jacket',
                'description' => 'Stylish bomber jacket with ribbed cuffs and hem. Perfect for casual outings.',
                'price_cents' => 11999,
                'discount_cents' => 1999,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800&h=800&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $men,
                'name' => 'Crew Neck Sweatshirt',
                'description' => 'Comfortable crew neck sweatshirt with soft fleece lining. Great for layering.',
                'price_cents' => 5499,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $men,
                'name' => 'Dress Pants',
                'description' => 'Classic dress pants with wrinkle-resistant fabric. Perfect for business attire.',
                'price_cents' => 8999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $women,
                'name' => 'Off-Shoulder Top',
                'description' => 'Trendy off-shoulder top with ruffle details. Perfect for summer styling.',
                'price_cents' => 3999,
                'discount_cents' => 499,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $women,
                'name' => 'A-Line Skirt',
                'description' => 'Flattering A-line skirt with comfortable fit. Versatile for any occasion.',
                'price_cents' => 5499,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1594633313593-bab3825d0caf?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $women,
                'name' => 'Trench Coat',
                'description' => 'Classic trench coat with belted waist. Timeless outerwear piece.',
                'price_cents' => 12999,
                'discount_cents' => 2499,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800&h=800&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1594938291221-94f313afa0f4?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $kids,
                'name' => 'Kids Jogger Pants',
                'description' => 'Comfortable jogger pants with elastic waistband. Perfect for active kids.',
                'price_cents' => 2999,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $kids,
                'name' => 'Kids Winter Jacket',
                'description' => 'Warm winter jacket for kids with water-resistant outer shell. Perfect for cold weather.',
                'price_cents' => 5999,
                'discount_cents' => 999,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $accessories,
                'name' => 'Leather Gloves',
                'description' => 'Premium leather gloves with soft lining. Perfect for winter.',
                'price_cents' => 3499,
                'discount_cents' => 0,
                'is_featured' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1624222247344-550fb60583fd?w=800&h=800&fit=crop&q=80',
                ],
            ],
            [
                'category' => $accessories,
                'name' => 'Backpack',
                'description' => 'Durable backpack with multiple compartments. Perfect for work or travel.',
                'price_cents' => 6999,
                'discount_cents' => 1499,
                'is_featured' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=800&h=800&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=800&fit=crop&q=80',
                ],
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'category_id' => $productData['category']->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'price_cents' => $productData['price_cents'],
                'discount_cents' => $productData['discount_cents'],
                'is_featured' => $productData['is_featured'],
                'is_active' => true,
            ]);

            // Add product images
            foreach ($productData['images'] as $index => $imageUrl) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $imageUrl,
                    'sort_order' => $index,
                ]);
            }

            // Add variants (sizes and colors)
            $productSizes = in_array($productData['category']->name, ['Accessories']) 
                ? ['One Size'] 
                : array_slice($sizes, 0, 4); // S, M, L, XL

            $productColors = in_array($productData['category']->name, ['Accessories'])
                ? array_slice($colors, 0, 3) // Fewer colors for accessories
                : array_slice($colors, 0, 4); // 4 colors for clothing

            foreach ($productSizes as $size) {
                foreach ($productColors as $color) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size' => $size,
                        'color' => $color,
                        'stock' => rand(5, 50), // Random stock between 5-50
                    ]);
                }
            }
        }

        $this->command->info('Created ' . count($products) . ' clothing products with images and variants!');
    }
}
