<?php

namespace App\Models;

use Database\Factories\CashoutLogFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $merchant_id
 * @property int $agent_id
 * @property int $amount
 * @property Carbon $recorded_at
 */
#[Fillable(['merchant_id', 'agent_id', 'amount', 'recorded_at'])]
class CashoutLog extends Model
{
    /** @use HasFactory<CashoutLogFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'recorded_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Merchant, $this>
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * @return BelongsTo<Agent, $this>
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }
}
