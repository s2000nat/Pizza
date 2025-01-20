<?php

namespace App\Http\Services;

use App\Http\DTO\LocationDTO;
use App\Models\Location;

class LocationService
{

    public function createLocation(LocationDTO $locationDTO): Location
    {
        $newLocation = Location::create(
            [
            'city' => $locationDTO->city,
            'street' => $locationDTO->street,
            'house_number' => $locationDTO->house_number,
            'floor' => $locationDTO->floor,
            'apartment' => $locationDTO->apartment,
            'user_id' => $locationDTO->user_id
            ]
        );
        return $newLocation;
    }

    public function updateLocation(Location $location, LocationDTO $locationDTO): Location
    {
        if ($locationDTO->city !== null) {
            $location->city = $locationDTO->city;
        }

        if ($locationDTO->street !== null) {
            $location->street = $locationDTO->street;
        }

        if ($locationDTO->house_number !== null) {
            $location->house_number = $locationDTO->house_number; // обратите внимание на стиль именования
        }

        if ($locationDTO->floor !== null) {
            $location->floor = $locationDTO->floor;
        }

        if ($locationDTO->apartment !== null) {
            $location->apartment = $locationDTO->apartment;
        }

        $location->deleted = $locationDTO->deleted;

        $location->save();

        return $location;
    }
}
