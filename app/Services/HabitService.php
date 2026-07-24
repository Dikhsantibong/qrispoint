<?php

namespace App\Services;

use App\Enums\MerchantStatus;
use App\Models\Merchant;

class HabitService
{
    /**
     * Recompute and persist a merchant's habit status based on how many
     * transactions it recorded within the habit window since onboarding.
     *
     * Thresholds (config('qrispoint')):
     * - 0 transaksi            => baru
     * - 1..(threshold-3)       => mencoba
     * - (threshold-2)..(threshold-1) => hampir
     * - >= threshold            => rutin
     */
    public function refreshStatus(Merchant $merchant): MerchantStatus
    {
        $status = $this->statusForTransactionCount($this->transactionsInWindow($merchant));

        if ($merchant->status !== $status) {
            $merchant->status = $status;
            $merchant->save();
        }

        return $status;
    }

    /**
     * Count transactions recorded within the habit window since onboarding.
     */
    public function transactionsInWindow(Merchant $merchant): int
    {
        $windowDays = config('qrispoint.habit_window_days');

        $windowEnd = $merchant->onboarded_at->copy()->addDays($windowDays)->endOfDay();

        return $merchant->transactions()
            ->where('recorded_at', '>=', $merchant->onboarded_at->copy()->startOfDay())
            ->where('recorded_at', '<=', $windowEnd)
            ->count();
    }

    private function statusForTransactionCount(int $count): MerchantStatus
    {
        $threshold = config('qrispoint.habit_threshold_tx');

        return match (true) {
            $count >= $threshold => MerchantStatus::Rutin,
            $count >= $threshold - 2 => MerchantStatus::Hampir,
            $count >= 1 => MerchantStatus::Mencoba,
            default => MerchantStatus::Baru,
        };
    }
}
