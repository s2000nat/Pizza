<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $city
 * @property string $street
 * @property string $house_number
 * @property int $floor
 * @property int $apartment
 */
class LocationResource extends JsonResource
{
    /**
     * @param  Request $request
     * @return array<string, int|string>
     */
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
