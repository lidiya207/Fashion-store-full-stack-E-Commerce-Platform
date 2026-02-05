<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AddressController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $addresses = auth()->user()->addresses()->orderBy('is_default', 'desc')->get();

        return AddressResource::collection($addresses);
    }

    public function store(StoreAddressRequest $request): JsonResponse
    {
        $data = $request->validated();

        // If this is set as default, unset other defaults
        if ($data['is_default'] ?? false) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        $address = auth()->user()->addresses()->create($data);

        return response()->json([
            'address' => AddressResource::make($address),
        ], 201);
    }

    public function update(UpdateAddressRequest $request, Address $address): JsonResponse
    {
        // Ensure user owns this address
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validated();

        // If this is set as default, unset other defaults
        if ($data['is_default'] ?? false) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($data);

        return response()->json([
            'address' => AddressResource::make($address->fresh()),
        ]);
    }

    public function destroy(Address $address): JsonResponse
    {
        // Ensure user owns this address
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->delete();

        return response()->json([], 204);
    }

    public function setDefault(Address $address): JsonResponse
    {
        // Ensure user owns this address
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        // Unset other defaults
        auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);

        $address->update(['is_default' => true]);

        return response()->json([
            'address' => AddressResource::make($address->fresh()),
        ]);
    }
}
