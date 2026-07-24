<?php

namespace App\Http\Responses;

use App\Enums\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Send agents straight to their mobile-first field dashboard; other
     * roles fall back to the application's configured home.
     */
    public function toResponse($request): RedirectResponse
    {
        /** @var Request $request */
        $user = $request->user();

        if ($user->role === UserRole::Agent) {
            return redirect()->route('agent.dashboard');
        }

        return redirect()->intended(config('fortify.home'));
    }
}
