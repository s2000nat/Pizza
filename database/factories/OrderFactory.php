<?php

namespace Database\Factories;

use App\Helpers\RandomDataGenerator;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phone_number' => RandomDataGenerator::randomPhoneNumberGenerator(),
            'location_id' => Location::factory(),
            'status' => 'in preparation',
        ];
    }
}
