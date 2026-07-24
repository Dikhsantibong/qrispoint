<?php

namespace Database\Factories;

use App\Enums\MerchantStatus;
use App\Models\Agent;
use App\Models\Market;
use App\Models\Merchant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Merchant>
 */
class MerchantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'agent_id' => Agent::factory(),
            'market_id' => Market::factory(),
            'name' => 'Warung '.fake()->firstName(),
            'category' => fake()->randomElement(['Sembako', 'Kuliner', 'Pakaian', 'Sayur & Buah', 'Ikan Segar']),
            'owner_phone' => fake()->numerify('08##########'),
            'status' => MerchantStatus::Baru,
            'onboarded_at' => fake()->dateTimeBetween('-14 days', 'now'),
            'photo_path' => null,
            'latitude' => fake()->latitude(-2.9, -0.8),
            'longitude' => fake()->longitude(131.0, 134.5),
        ];
    }
}
