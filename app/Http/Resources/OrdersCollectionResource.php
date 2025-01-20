<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrdersCollectionResource extends ResourceCollection
{

    public $collects = OrderResource::class;

    /**
     * @param  $request
     * @return array<string, string>
     */
    public function toArray($request): array
    {
        return [
            'orders' => $this->collection
        ];
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray($request));
    }
}
