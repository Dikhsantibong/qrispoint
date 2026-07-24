<?php

namespace Database\Factories;

use App\Models\Market;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Market>
 */
class MarketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Pasar '.fake()->city(),
            'city' => fake()->city(),
            'latitude' => fake()->latitude(-2.9, -0.8),
            'longitude' => fake()->longitude(131.0, 134.5),
        ];
    }
}
