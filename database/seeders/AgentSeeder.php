<?php

namespace Database\Seeders;

use App\Enums\LakuPandaiType;
use App\Models\Agent;
use App\Models\Market;
use App\Models\User;
use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $remu = Market::where('name', 'Pasar Remu')->firstOrFail();
        $sentral = Market::where('name', 'Pasar Sentral')->firstOrFail();

        $agents = [
            ['name' => 'Yohanes Kabes', 'email' => 'yohanes.kabes@qrispoint.test', 'market_id' => $remu->id, 'laku_pandai_type' => LakuPandaiType::BriLink],
            ['name' => 'Maria Rumbrapuk', 'email' => 'maria.rumbrapuk@qrispoint.test', 'market_id' => $remu->id, 'laku_pandai_type' => LakuPandaiType::MandiriAgen],
            ['name' => 'Petrus Sremba', 'email' => 'petrus.sremba@qrispoint.test', 'market_id' => $sentral->id, 'laku_pandai_type' => LakuPandaiType::BriLink],
            ['name' => 'Agustina Kalami', 'email' => 'agustina.kalami@qrispoint.test', 'market_id' => $sentral->id, 'laku_pandai_type' => LakuPandaiType::Lainnya],
        ];

        foreach ($agents as $data) {
            $user = User::factory()->create([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            Agent::create([
                'user_id' => $user->id,
                'market_id' => $data['market_id'],
                'phone' => fake()->numerify('08##########'),
                'laku_pandai_type' => $data['laku_pandai_type'],
            ]);
        }
    }
}
