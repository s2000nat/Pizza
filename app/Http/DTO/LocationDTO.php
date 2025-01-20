<?php

namespace App\Http\DTO;

class LocationDTO
{
    public function __construct(
        public int     $user_id ,
        public ?string $city = null,
        public ?string $street = null,
        public ?string $house_number = null,
        public ?int    $floor = null,
        public ?int    $apartment = null,
        public bool    $deleted = false,
    ) {
    }
}
