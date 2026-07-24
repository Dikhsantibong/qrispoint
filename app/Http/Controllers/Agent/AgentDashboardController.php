<?php

namespace App\Http\Controllers\Agent;

use App\Enums\IncentiveStatus;
use App\Http\Controllers\Controller;
use App\Models\Incentive;
use App\Services\HabitService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AgentDashboardController extends Controller
{
    public function __construct(
        private readonly HabitService $habitService,
    ) {}

    /**
     * Show the agent's home: their merchants and incentive summary.
     */
    public function index(Request $request): Response
    {
        $agent = $request->user()->agent()->with('market')->firstOrFail();

        $merchants = $agent->merchants()
            ->orderBy('name')
            ->get()
            ->map(fn ($merchant) => [
                'id' => $merchant->id,
                'name' => $merchant->name,
                'category' => $merchant->category,
                'status' => $merchant->status->value,
                'tx_in_window' => $this->habitService->transactionsInWindow($merchant),
            ]);

        return Inertia::render('agent/dashboard', [
            'agentName' => $request->user()->name,
            'market' => [
                'name' => $agent->market->name,
                'city' => $agent->market->city,
            ],
            'merchants' => $merchants,
            'incentiveSummary' => [
                'totalCair' => (int) Incentive::where('agent_id', $agent->id)->where('status', IncentiveStatus::Cair)->sum('amount'),
                'totalPending' => (int) Incentive::where('agent_id', $agent->id)->where('status', IncentiveStatus::Pending)->sum('amount'),
            ],
            'habitThresholdTx' => config('qrispoint.habit_threshold_tx'),
        ]);
    }
}
