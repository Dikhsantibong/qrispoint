<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Merchant;
use App\Models\MerchantTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the monitoring dashboard for coordinators and viewers.
     */
    public function index(Request $request): Response
    {
        $totalAgents = Agent::count();
        $totalMerchants = Merchant::count();
        $totalTransactions = MerchantTransaction::count();
        $totalVolume = MerchantTransaction::sum('amount');

        $recentMerchants = Merchant::with(['agent.user', 'market'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($merchant) {
                return [
                    'id' => $merchant->id,
                    'name' => $merchant->name,
                    'category' => $merchant->category,
                    'status' => $merchant->status->value,
                    'onboarded_at' => $merchant->onboarded_at->format('Y-m-d'),
                    'agent_name' => $merchant->agent->user->name ?? '-',
                    'market_name' => $merchant->market->name ?? '-',
                ];
            });

        return Inertia::render('dashboard', [
            'metrics' => [
                'totalAgents' => $totalAgents,
                'totalMerchants' => $totalMerchants,
                'totalTransactions' => $totalTransactions,
                'totalVolume' => $totalVolume,
            ],
            'recentMerchants' => $recentMerchants,
        ]);
    }
}
