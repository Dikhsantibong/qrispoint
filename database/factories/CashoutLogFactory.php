<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\CashoutLog;
use App\Models\Merchant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CashoutLog>
 */
class CashoutLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'merchant_id' => Merchant::factory(),
            'agent_id' => Agent::factory(),
            'amount' => fake()->numberBetween(20_000, 300_000),
            'recorded_at' => fake()->dateTimeBetween('-14 days', 'now'),
        ];
    }
}
