<?php

namespace App\Http\DTO;

class OrderDTO
{
    public function __construct(public int $userId, public string $phoneNumber, public int $locationId, public string $status)
    {
    }
}
