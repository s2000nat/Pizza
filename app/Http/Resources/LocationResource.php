<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'city' => $this->city,
            'street' => $this->street,
            'house_number' => $this->house_number,
            'floor' => $this->floor,
            'apartment' => $this->apartment,
        ];
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray($request));
    }
}
