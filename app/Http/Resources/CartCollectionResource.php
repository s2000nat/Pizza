<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollectionResource extends ResourceCollection
{
    /**
     * @param  $request
     * @return array<string, string>
     */
    public function toArray($request): array
    {
        return [
            'products' => $this->collection->map(
                function ($cartItem) {
                    return [
                    'id' => $cartItem->product->id,
                    'product_name' => $cartItem->product->menuItem->name,
                    'product_size' => $cartItem->product->categorySizePrice->size->slug,
                    'price' => $cartItem->product->categorySizePrice->price,
                    'quantity' => $cartItem->quantity,
                    ];
                }
            ),
            'total_price' => $this->collection->sum(
                function ($cartItem) {
                    return $cartItem->product->categorySizePrice->price * $cartItem->quantity;
                }
            ),
        ];
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray($request));
    }
}
