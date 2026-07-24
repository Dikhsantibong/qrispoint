<?php

namespace App\Models;

use Database\Factories\MarketFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $city
 * @property float|null $latitude
 * @property float|null $longitude
 */
#[Fillable(['name', 'city', 'latitude', 'longitude'])]
class Market extends Model
{
    /** @use HasFactory<MarketFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    /**
     * @return HasMany<Agent, $this>
     */
    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class);
    }

    /**
     * @return HasMany<Merchant, $this>
     */
    public function merchants(): HasMany
    {
        return $this->hasMany(Merchant::class);
    }
}
