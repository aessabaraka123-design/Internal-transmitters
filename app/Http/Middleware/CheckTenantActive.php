<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class CheckTenantActive
{
    public function handle(Request $request, Closure $next)
    {
        $tenant = tenant();

        if (! $tenant) {
            abort(404, 'الشركة غير موجودة');
        }

        $isActive = $tenant->is_active ?? false;

        if (! $isActive) {
            return response()->view('tenant.suspended', [], 403);
        }

        $subscriptionEnds = $tenant->subscription_ends_at ?? null;
        $trialEnds        = $tenant->trial_ends_at ?? null;

        $hasValidSubscription = $subscriptionEnds && now()->lt($subscriptionEnds);
        $hasValidTrial        = $trialEnds && now()->lt($trialEnds);

        if (! $hasValidSubscription && ! $hasValidTrial) {
            return response()->view('tenant.subscription-expired', compact('tenant'), 402);
        }

        return $next($request);
    }
}