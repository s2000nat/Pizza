<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartDetailsCollectionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->product->id,
            'product_name' => $this->product->menuItem->name,
            'product_size' => $this->product->categorySizePrice->size->slug,
            'price' => $this->product->categorySizePrice->price,
            'quantity' => $this->quantity,
        ];
    }
}
