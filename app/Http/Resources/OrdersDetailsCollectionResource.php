<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrdersDetailsCollectionResource extends ResourceCollection
{

    public function toArray($request): array
    {
        return ['orders' => $this->collection->map(function ($order) {
            return [
                'created_at' => $order->created_at->toDateTimeString(),
                'status' => $order->status,
                'products' => $order->orderProduct->map(function ($orderProduct) {
                    return [
                        'product_id' => $orderProduct->product_id,
                        'product_name' => $orderProduct->product->menuItem->name,
                        'quantity' => $orderProduct->quantity,
                        'size' => $orderProduct->product->categorySizePrice->size->slug,
                        'categorySizePrice' => $orderProduct->product->categorySizePrice->price,

                    ];
                }),
                'totalPrice' => $order->orderProduct->sum(function ($orderItem) {
                    return $orderItem->product->categorySizePrice->price * $orderItem->quantity;
                }),
            ];
        })->values()->toArray()
        ];

    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray($request));
    }
}
