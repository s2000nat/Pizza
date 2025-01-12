<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrepareOrderDetailsResource extends JsonResource
{
    public function __construct(array $resource)
    {
        parent::__construct((object)$resource); // Преобразуем массив в объект
    }

    public function toArray($request): array
    {
        return [
            'locations' => LocationResource::collection($this->locations),
            'products' => new CartDetailsCollectionResource($this->cart),
            'phone_number' => $this->user->phone_number,
        ];
    }
}
