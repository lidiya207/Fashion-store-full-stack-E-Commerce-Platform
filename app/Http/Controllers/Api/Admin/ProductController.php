<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductAdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->integer('per_page', 20);
        $perPage = max(1, min(100, $perPage));

        $query = Product::query()->with(['category', 'images', 'variants']);

        if ($request->filled('q')) {
            $q = trim((string) $request->query('q'));
            $query->where('name', 'like', "%{$q}%")->orWhere('slug', 'like', "%{$q}%");
        }

        return ProductResource::collection(
            $query->orderByDesc('id')->paginate($perPage)
        );
    }

    public function store(ProductStoreRequest $request, ProductAdminService $service): JsonResponse
    {
        $product = $service->create($request->validated());

        return response()->json([
            'product' => ProductResource::make($product->load(['category', 'images', 'variants'])),
        ], 201);
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'variants']);

        return ProductResource::make($product);
    }

    public function update(ProductUpdateRequest $request, Product $product, ProductAdminService $service): JsonResponse
    {
        $product = $service->update($product, $request->validated());

        return response()->json([
            'product' => ProductResource::make($product->load(['category', 'images', 'variants'])),
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([], 204);
    }
}

