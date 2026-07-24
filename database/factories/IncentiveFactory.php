<?php

namespace Database\Factories;

use App\Enums\IncentiveStatus;
use App\Enums\IncentiveType;
use App\Models\Agent;
use App\Models\Incentive;
use App\Models\Merchant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Incentive>
 */
class IncentiveFactory extends Factory
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
            'merchant_id' => Merchant::factory(),
            'type' => IncentiveType::FirstTx,
            'amount' => config('qrispoint.incentive_first_tx'),
            'status' => IncentiveStatus::Cair,
            'earned_at' => now(),
        ];
    }

    public function activation(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => IncentiveType::Activation,
            'amount' => config('qrispoint.incentive_activation'),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => IncentiveStatus::Pending,
            'earned_at' => null,
        ]);
    }
}
