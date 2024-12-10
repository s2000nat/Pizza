<?php

namespace App\Http\Resources;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    const collection = ;/

    public function toArray($request): array
    {
        return [
            'cart_items' => CartDetailsCollectionResource::collection($this->product),
            'total_price' => $this->user->totalCartPrice,
        ];
    }
}
