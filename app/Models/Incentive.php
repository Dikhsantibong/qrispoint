<?php

namespace App\Models;

use App\Enums\IncentiveStatus;
use App\Enums\IncentiveType;
use Database\Factories\IncentiveFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $agent_id
 * @property int $merchant_id
 * @property IncentiveType $type
 * @property int $amount
 * @property IncentiveStatus $status
 * @property Carbon|null $earned_at
 */
#[Fillable(['agent_id', 'merchant_id', 'type', 'amount', 'status', 'earned_at'])]
class Incentive extends Model
{
    /** @use HasFactory<IncentiveFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'type' => IncentiveType::class,
            'amount' => 'integer',
            'status' => IncentiveStatus::class,
            'earned_at' => 'datetime',
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
     * @return BelongsTo<Merchant, $this>
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
}
