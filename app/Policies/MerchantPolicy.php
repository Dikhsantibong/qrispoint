<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Merchant;
use App\Models\User;

class MerchantPolicy
{
    /**
     * Determine whether the user can view the merchant.
     *
     * Agents may only view merchants they personally dampingi; coordinators
     * and viewers see everything (read access, enforced further in Fase 2).
     */
    public function view(User $user, Merchant $merchant): bool
    {
        if ($user->role !== UserRole::Agent) {
            return true;
        }

        return $user->agent?->id === $merchant->agent_id;
    }

    /**
     * Determine whether the user can record activity (transaksi, tarik
     * tunai, verifikasi kupon) against the merchant.
     */
    public function manage(User $user, Merchant $merchant): bool
    {
        return $user->role === UserRole::Agent && $user->agent?->id === $merchant->agent_id;
    }
}
