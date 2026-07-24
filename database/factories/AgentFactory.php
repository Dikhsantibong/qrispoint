<?php

namespace Database\Factories;

use App\Enums\LakuPandaiType;
use App\Models\Agent;
use App\Models\Market;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Agent>
 */
class AgentFactory extends Factory
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
            'market_id' => Market::factory(),
            'phone' => fake()->numerify('08##########'),
            'laku_pandai_type' => fake()->randomElement(LakuPandaiType::cases()),
        ];
    }
}
