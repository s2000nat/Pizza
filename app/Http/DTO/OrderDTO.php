<?php

namespace App\Http\DTO;

class OrderDTO
{
    public function __construct(
        public ?int    $userId = null,
        public ?string $phoneNumber = null,
        public ?int    $locationId = null,
        public ?string $status = null)
    {
    }
}
