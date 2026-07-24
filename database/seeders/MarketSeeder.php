<?php

namespace Database\Seeders;

use App\Models\Market;
use Illuminate\Database\Seeder;

class MarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Market::create([
            'name' => 'Pasar Remu',
            'city' => 'Kota Sorong',
            'latitude' => -0.8807,
            'longitude' => 131.2558,
        ]);

        Market::create([
            'name' => 'Pasar Sentral',
            'city' => 'Sorong Selatan',
            'latitude' => -1.1425,
            'longitude' => 131.6142,
        ]);
    }
}
