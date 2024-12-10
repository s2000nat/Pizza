<?php

namespace Database\Factories;

use App\Models\PriceCategory;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategorySizeprice>
 */
class CategorySizePriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price_category_id' => PriceCategory::factory(),
            'size_id' => Size::factory(),
            'price' => $this->faker->numberBetween(500, 1500),
        ];
    }
}
