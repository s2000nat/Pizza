<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LocationDetailsCollectionResource extends ResourceCollection
{

    public static string $responseType = 'location';


    public function toArray($request): array
    {
        return [
            'locations' => $this->collection->map(function ($location) {
                return [
                    'id' => $location->id,
                    'city' => $location->city,
                    'street' => $location->street,
                    'house_number' => $location->house_number,
                    'floor' => $location->floor,
                    'apartment' => $location->apartment,
                ];
            }),
        ];
    }

}
