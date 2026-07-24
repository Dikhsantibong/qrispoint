<?php

namespace Database\Factories;

use App\Enums\TransactionSource;
use App\Models\Merchant;
use App\Models\MerchantTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MerchantTransaction>
 */
class MerchantTransactionFactory extends Factory
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
            'amount' => fake()->numberBetween(10_000, 250_000),
            'recorded_at' => fake()->dateTimeBetween('-14 days', 'now'),
            'source' => TransactionSource::AgentManual,
        ];
    }
}
