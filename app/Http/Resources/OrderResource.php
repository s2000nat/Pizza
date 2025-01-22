<?php

namespace App\Http\Resources;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property User $user
 * @property mixed $created_at
 * @property Location $location
 * @property mixed $status
 * @property mixed $orderProduct
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'created_at' => $this->created_at->toDateTimeString(),
            'location' => new LocationResource($this->location),
            'status' => $this->status,
            'products' => $this->orderProduct->map(
                function ($orderProduct) {
                    return [
                    'product_id' => $orderProduct->product_id,
                    'product_name' => $orderProduct->product->menuItem->name,
                    'quantity' => $orderProduct->quantity,
                    'size' => $orderProduct->product->categorySizePrice->size->slug,
                    'categorySizePrice' => $orderProduct->product->categorySizePrice->price,
                    ];
                }
            ),
            'totalPrice' => $this->orderProduct->sum(
                function ($orderItem) {
                    return $orderItem->product->categorySizePrice->price * $orderItem->quantity;
                }
            ),
        ];
    }
}
