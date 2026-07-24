<?php

namespace App\Models;

use App\Enums\MerchantStatus;
use Database\Factories\MerchantFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $agent_id
 * @property int $market_id
 * @property string $name
 * @property string $category
 * @property string $owner_phone
 * @property MerchantStatus $status
 * @property Carbon $onboarded_at
 * @property string|null $photo_path
 * @property float|null $latitude
 * @property float|null $longitude
 */
#[Fillable(['agent_id', 'market_id', 'name', 'category', 'owner_phone', 'status', 'onboarded_at', 'photo_path', 'latitude', 'longitude'])]
class Merchant extends Model
{
    /** @use HasFactory<MerchantFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => MerchantStatus::class,
            'onboarded_at' => 'date',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    /**
     * @return BelongsTo<Agent, $this>
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * @return BelongsTo<Market, $this>
     */
    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    /**
     * @return HasMany<MerchantTransaction, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(MerchantTransaction::class);
    }

    /**
     * @return HasMany<CashoutLog, $this>
     */
    public function cashoutLogs(): HasMany
    {
        return $this->hasMany(CashoutLog::class);
    }

    /**
     * @return HasMany<Incentive, $this>
     */
    public function incentives(): HasMany
    {
        return $this->hasMany(Incentive::class);
    }
}
