<?php

namespace Database\Seeders;

use App\Enums\TransactionSource;
use App\Models\Agent;
use App\Models\Merchant;
use App\Services\HabitService;
use App\Services\IncentiveService;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds 15 merchants across the 4 agents. Five of them receive a
     * transaction history engineered so FunnelService::summary() lands
     * near the pilot targets: ~35% pernah transaksi (5/15) and ~12%
     * repeat users (2/15, i.e. merchants with >=4 tx in the last 7 days).
     */
    public function run(): void
    {
        $habitService = app(HabitService::class);
        $incentiveService = app(IncentiveService::class);

        $agents = Agent::orderBy('id')->get();

        // Each plan: which agent dampingi it, and days-ago (oldest first)
        // for every transaction recorded within the 14-day habit window.
        $activePlans = [
            ['agent' => 0, 'name' => 'Warung Bahagia', 'tx_days_ago' => [12, 11, 10, 9, 8, 7, 6, 5, 4, 2, 0]], // 11 tx, 5 in last 7d -> rutin, activation, repeat
            ['agent' => 0, 'name' => 'Toko Sembako Berkat', 'tx_days_ago' => [12, 10, 8, 6, 4, 2, 0]], // 7 tx, 4 in last 7d -> rutin, repeat
            ['agent' => 1, 'name' => 'Kios Ikan Segar Papua', 'tx_days_ago' => [12, 10, 8, 6, 3, 1]], // 6 tx, 3 in last 7d -> hampir
            ['agent' => 2, 'name' => 'Warung Sayur Mama', 'tx_days_ago' => [11, 9, 3]], // 3 tx, 1 in last 7d -> mencoba
            ['agent' => 3, 'name' => 'Toko Pakaian Rapi', 'tx_days_ago' => [10, 2]], // 2 tx, 1 in last 7d -> mencoba
        ];

        foreach ($activePlans as $plan) {
            $agent = $agents[$plan['agent']];

            $merchant = Merchant::factory()->create([
                'agent_id' => $agent->id,
                'market_id' => $agent->market_id,
                'name' => $plan['name'],
                'onboarded_at' => now()->subDays(13),
            ]);

            foreach ($plan['tx_days_ago'] as $daysAgo) {
                $merchant->transactions()->create([
                    'amount' => fake()->numberBetween(15_000, 150_000),
                    'recorded_at' => now()->subDays($daysAgo)->setTime(fake()->numberBetween(8, 18), fake()->numberBetween(0, 59)),
                    'source' => TransactionSource::AgentManual,
                ]);

                $habitService->refreshStatus($merchant);
                $incentiveService->evaluate($merchant);
            }

            $merchant->cashoutLogs()->create([
                'agent_id' => $agent->id,
                'amount' => fake()->numberBetween(50_000, 400_000),
                'recorded_at' => now()->subDay(),
            ]);
        }

        // Remaining merchants (status "baru") spread across the agents
        // so the roster totals 15.
        foreach ([0 => 2, 1 => 3, 2 => 3, 3 => 2] as $agentIndex => $count) {
            $agent = $agents[$agentIndex];

            Merchant::factory($count)->create([
                'agent_id' => $agent->id,
                'market_id' => $agent->market_id,
                'onboarded_at' => now()->subDays(fake()->numberBetween(1, 13)),
            ]);
        }
    }
}
