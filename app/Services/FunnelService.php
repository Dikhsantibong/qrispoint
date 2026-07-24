<?php

namespace App\Services;

use App\Models\Merchant;
use Illuminate\Support\Collection;

class FunnelService
{
    /**
     * Aggregate the adoption funnel and headline KPIs, optionally scoped to
     * one market.
     *
     * Funnel stages (each a subset of the previous):
     * - terjangkau: seluruh merchant yang didampingi (denominator)
     * - aktif: pernah bertransaksi minimal sekali (kapan saja)
     * - mencoba: aktif namun transaksi seumur hidupnya belum mencapai
     *   ambang activation_tx — masih dalam masa percobaan
     * - repeat: >= repeat_user_min_tx_per_week transaksi dalam 7 hari terakhir
     *
     * @return array{
     *     terjangkau: int,
     *     aktif: int,
     *     mencoba: int,
     *     repeat: int,
     *     retensi_trial_repeat: float,
     *     repeat_usage_rate: float,
     *     median_tx_per_merchant_aktif: float,
     * }
     */
    public function summary(?int $marketId = null): array
    {
        $merchants = Merchant::query()
            ->when($marketId, fn ($query) => $query->where('market_id', $marketId))
            ->withCount(['transactions as lifetime_tx_count'])
            ->with(['transactions' => function ($query) {
                $query->where('recorded_at', '>=', now()->subDays(7));
            }])
            ->get();

        $terjangkau = $merchants->count();

        $activationThreshold = config('qrispoint.activation_tx');
        $repeatMinTxPerWeek = config('qrispoint.repeat_user_min_tx_per_week');

        $aktifMerchants = $merchants->filter(fn (Merchant $merchant) => $merchant->lifetime_tx_count >= 1);
        $repeatMerchants = $merchants->filter(fn (Merchant $merchant) => $merchant->transactions->count() >= $repeatMinTxPerWeek);
        $mencobaMerchants = $aktifMerchants->filter(fn (Merchant $merchant) => $merchant->lifetime_tx_count < $activationThreshold);

        $aktif = $aktifMerchants->count();
        $mencoba = $mencobaMerchants->count();
        $repeat = $repeatMerchants->count();

        return [
            'terjangkau' => $terjangkau,
            'aktif' => $aktif,
            'mencoba' => $mencoba,
            'repeat' => $repeat,
            'retensi_trial_repeat' => $this->percentage($repeat, $aktif),
            'repeat_usage_rate' => $this->percentage($repeat, $terjangkau),
            'median_tx_per_merchant_aktif' => $this->medianDailyTxPerActiveMerchant($aktifMerchants),
        ];
    }

    /**
     * @param  Collection<int, Merchant>  $activeMerchants
     */
    private function medianDailyTxPerActiveMerchant(Collection $activeMerchants): float
    {
        if ($activeMerchants->isEmpty()) {
            return 0.0;
        }

        $dailyRates = $activeMerchants
            ->map(fn (Merchant $merchant) => $merchant->transactions->count() / 7)
            ->sort()
            ->values();

        $count = $dailyRates->count();
        $middle = intdiv($count, 2);

        if ($count % 2 === 0) {
            return round(($dailyRates[$middle - 1] + $dailyRates[$middle]) / 2, 2);
        }

        return round($dailyRates[$middle], 2);
    }

    private function percentage(int $numerator, int $denominator): float
    {
        if ($denominator === 0) {
            return 0.0;
        }

        return round(($numerator / $denominator) * 100, 1);
    }
}
