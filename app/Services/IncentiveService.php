<?php

namespace App\Services;

use App\Enums\IncentiveStatus;
use App\Enums\IncentiveType;
use App\Models\Incentive;
use App\Models\Merchant;

class IncentiveService
{
    /**
     * Evaluate whether a merchant's recorded transactions just crossed an
     * incentive-earning milestone, and cair (pay out) the incentive to its
     * agent if so. Idempotent: the (merchant_id, type) unique constraint on
     * `incentives` guarantees each milestone only ever cairs once.
     *
     * @return array{first_tx: ?Incentive, activation: ?Incentive} the
     *         incentives newly cair as a result of this evaluation (null
     *         where that milestone wasn't just reached)
     */
    public function evaluate(Merchant $merchant): array
    {
        return [
            'first_tx' => $this->evaluateFirstTransaction($merchant),
            'activation' => $this->evaluateActivation($merchant),
        ];
    }

    private function evaluateFirstTransaction(Merchant $merchant): ?Incentive
    {
        if ($merchant->transactions()->count() !== 1) {
            return null;
        }

        return $this->cair($merchant, IncentiveType::FirstTx, config('qrispoint.incentive_first_tx'));
    }

    private function evaluateActivation(Merchant $merchant): ?Incentive
    {
        $habitService = app(HabitService::class);

        if ($habitService->transactionsInWindow($merchant) < config('qrispoint.activation_tx')) {
            return null;
        }

        return $this->cair($merchant, IncentiveType::Activation, config('qrispoint.incentive_activation'));
    }

    private function cair(Merchant $merchant, IncentiveType $type, int $amount): ?Incentive
    {
        $incentive = Incentive::firstOrCreate(
            ['merchant_id' => $merchant->id, 'type' => $type],
            [
                'agent_id' => $merchant->agent_id,
                'amount' => $amount,
                'status' => IncentiveStatus::Cair,
                'earned_at' => now(),
            ],
        );

        return $incentive->wasRecentlyCreated ? $incentive : null;
    }
}
