<?php

declare(strict_types=1);

namespace App\Http\DTO;

class ProductDTO
{
    public function __construct(
        public int $menuItemId,
        public int $categorySizePriceId
    ) {
    }
}
