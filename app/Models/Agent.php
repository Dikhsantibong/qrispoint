<?php

namespace App\Models;

use App\Enums\LakuPandaiType;
use Database\Factories\AgentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $market_id
 * @property string $phone
 * @property LakuPandaiType $laku_pandai_type
 */
#[Fillable(['user_id', 'market_id', 'phone', 'laku_pandai_type'])]
class Agent extends Model
{
    /** @use HasFactory<AgentFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'laku_pandai_type' => LakuPandaiType::class,
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Market, $this>
     */
    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    /**
     * @return HasMany<Merchant, $this>
     */
    public function merchants(): HasMany
    {
        return $this->hasMany(Merchant::class);
    }

    /**
     * @return HasMany<Incentive, $this>
     */
    public function incentives(): HasMany
    {
        return $this->hasMany(Incentive::class);
    }

    /**
     * @return HasMany<CashoutLog, $this>
     */
    public function cashoutLogs(): HasMany
    {
        return $this->hasMany(CashoutLog::class);
    }
}
