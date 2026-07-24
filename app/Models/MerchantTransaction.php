<?php

namespace App\Models;

use App\Enums\TransactionSource;
use Database\Factories\MerchantTransactionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $merchant_id
 * @property int $amount
 * @property Carbon $recorded_at
 * @property TransactionSource $source
 */
#[Fillable(['merchant_id', 'amount', 'recorded_at', 'source'])]
class MerchantTransaction extends Model
{
    /** @use HasFactory<MerchantTransactionFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'recorded_at' => 'datetime',
            'source' => TransactionSource::class,
        ];
    }

    /**
     * @return BelongsTo<Merchant, $this>
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
}
