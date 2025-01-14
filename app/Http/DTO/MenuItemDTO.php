<?php

namespace App\Http\DTO;

class MenuItemDTO
{
    public function __construct(
        public ?string $name = null,
        public ?string $description = null,
        public ?int    $priceCategoryId = null)
    {
    }
}
