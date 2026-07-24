<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->coordinator()->create([
            'name' => 'Koordinator Program',
            'email' => 'koordinator@qrispoint.test',
        ]);

        User::factory()->viewer()->create([
            'name' => 'Bank Indonesia Viewer',
            'email' => 'viewer@qrispoint.test',
        ]);

        $this->call([
            MarketSeeder::class,
            AgentSeeder::class,
            MerchantSeeder::class,
        ]);
    }
}
