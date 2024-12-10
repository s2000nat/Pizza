<?php

declare(strict_types=1);

namespace App\Http\DTO;

class CartDTO
{
    public function __construct(public int $productId, public int $userId)
    {
    }
}
