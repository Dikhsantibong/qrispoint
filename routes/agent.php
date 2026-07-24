<?php

use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\Agent\AgentMerchantController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:agent'])->prefix('agen')->name('agent.')->group(function () {
    Route::get('/', [AgentDashboardController::class, 'index'])->name('dashboard');

    Route::get('merchants/{merchant}', [AgentMerchantController::class, 'show'])->name('merchants.show');
    Route::post('merchants/{merchant}/transactions', [AgentMerchantController::class, 'storeTransaction'])->name('merchants.transactions.store');
    Route::post('merchants/{merchant}/cashouts', [AgentMerchantController::class, 'storeCashout'])->name('merchants.cashouts.store');
});
