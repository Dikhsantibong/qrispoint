<?php

namespace App\Http\Controllers\Agent;

use App\Enums\MerchantStatus;
use App\Enums\TransactionSource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\StoreCashoutRequest;
use App\Http\Requests\Agent\StoreMerchantTransactionRequest;
use App\Models\Incentive;
use App\Models\Merchant;
use App\Services\HabitService;
use App\Services\IncentiveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Inertia\Inertia;
use Inertia\Response;

class AgentMerchantController extends Controller
{
    public function __construct(
        private readonly HabitService $habitService,
        private readonly IncentiveService $incentiveService,
    ) {}

    /**
     * Show a merchant's habit progress and available actions.
     */
    #[Authorize('view', 'merchant')]
    public function show(Merchant $merchant): Response
    {
        return Inertia::render('agent/merchant-detail', [
            'merchant' => [
                'id' => $merchant->id,
                'name' => $merchant->name,
                'category' => $merchant->category,
                'status' => $merchant->status->value,
            ],
            'stats' => [
                'txInWindow' => $this->habitService->transactionsInWindow($merchant),
                'habitThresholdTx' => config('qrispoint.habit_threshold_tx'),
                'totalTx' => $merchant->transactions()->count(),
                'todayOmzet' => (int) $merchant->transactions()->whereDate('recorded_at', today())->sum('amount'),
                'totalCashout' => $merchant->cashoutLogs()->count(),
            ],
        ]);
    }

    /**
     * Record a QRIS transaction for the merchant, then refresh its habit
     * status and evaluate any incentives it just earned.
     */
    public function storeTransaction(StoreMerchantTransactionRequest $request, Merchant $merchant): RedirectResponse
    {
        $previousStatus = $merchant->status;

        $merchant->transactions()->create([
            'amount' => $request->validated()['amount'],
            'recorded_at' => now(),
            'source' => TransactionSource::AgentManual,
        ]);

        $newStatus = $this->habitService->refreshStatus($merchant);
        $incentives = $this->incentiveService->evaluate($merchant);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => $this->transactionToastMessage($incentives, $previousStatus, $newStatus),
        ]);

        return back();
    }

    /**
     * Record a same-day cash withdrawal for the merchant.
     */
    public function storeCashout(StoreCashoutRequest $request, Merchant $merchant): RedirectResponse
    {
        $merchant->cashoutLogs()->create([
            'agent_id' => $merchant->agent_id,
            'amount' => $request->validated()['amount'],
            'recorded_at' => now(),
        ]);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Tarik tunai tercatat.']);

        return back();
    }

    /**
     * @param  array{first_tx: ?Incentive, activation: ?Incentive}  $incentives
     */
    private function transactionToastMessage(array $incentives, MerchantStatus $previousStatus, MerchantStatus $newStatus): string
    {
        return match (true) {
            $incentives['first_tx'] !== null => 'Insentif Rp'.number_format($incentives['first_tx']->amount, 0, ',', '.').' cair 🎉',
            $incentives['activation'] !== null => 'Insentif Rp'.number_format($incentives['activation']->amount, 0, ',', '.').' cair 🎉',
            $previousStatus !== MerchantStatus::Rutin && $newStatus === MerchantStatus::Rutin => 'Status naik: RUTIN ✅',
            default => 'Transaksi tercatat.',
        };
    }
}
