<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->integer('per_page', 12);
        $perPage = max(1, min(48, $perPage));

        $query = Product::query()
            ->with(['category', 'images'])
            ->where('is_active', true);

        if ($request->filled('q')) {
            $q = trim((string) $request->query('q'));
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category')) {
            $category = (string) $request->query('category');
            $query->whereHas('category', function ($c) use ($category) {
                $c->where('slug', $category)->orWhere('id', $category);
            });
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        if ($request->filled('price_min')) {
            $query->where('price_cents', '>=', (int) $request->query('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price_cents', '<=', (int) $request->query('price_max'));
        }

        if ($request->filled('size') || $request->filled('color')) {
            $size = $request->filled('size') ? (string) $request->query('size') : null;
            $color = $request->filled('color') ? (string) $request->query('color') : null;

            $query->whereHas('variants', function ($v) use ($size, $color) {
                if ($size) {
                    $v->where('size', $size);
                }
                if ($color) {
                    $v->where('color', $color);
                }
                $v->where('stock', '>', 0);
            });
        }

        $products = $query
            ->orderByDesc('is_featured')
            ->orderByDesc('id')
            ->paginate($perPage);

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        // Allow viewing active products without authentication
        if (!$product->is_active) {
            abort(404);
        }

        $product->load(['category', 'images', 'variants']);

        return ProductResource::make($product);
    }

    public function categories()
    {
        $categories = \App\Models\Category::query()
            ->whereHas('products', function ($q) {
                $q->where('is_active', true);
            })
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return response()->json([
            'data' => $categories,
        ]);
    }
}

