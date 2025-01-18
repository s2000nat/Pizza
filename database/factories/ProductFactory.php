<?php

namespace Database\Factories;

use App\Models\CategorySizePrice;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'menu_item_id'=> MenuItem::factory(),
            'category_size_price_id' =>CategorySizePrice::factory(),
        ];
    }
}
