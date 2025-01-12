<?php

namespace App\Http\DTO;

class LocationDTO
{
    public function __construct(
        public ?string $city = null,
        public ?string $street = null,
        public ?string $house_number = null,
        public ?int    $floor = null,
        public ?int    $apartment = null,
        public int     $user_id ,
        public bool    $deleted = false,
    )
    {
    }
}
