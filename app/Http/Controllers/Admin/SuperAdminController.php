<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;


class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_tenants'  => Tenant::count(),
            'active_tenants' => Tenant::where('data->is_active', true)->count(),
            'total_revenue'  => $this->calculateRevenue(),
            'plans'          => $this->getPlanStats(),
        ];

        $recentTenants = Tenant::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentTenants'));
    }

    
    private function calculateRevenue(): float
    {
        $plans   = Tenant::plans();
        $revenue = 0;

        Tenant::all()->each(function ($tenant) use ($plans, &$revenue) {
            $plan     = $tenant->data['plan'] ?? 'basic';
            $revenue += $plans[$plan]['price'] ?? 0;
        });

        return $revenue;
    }

    
    private function getPlanStats(): array
    {
        $stats = [];
        foreach (['basic', 'pro', 'enterprise'] as $plan) {
            $stats[$plan] = Tenant::where('data->plan', $plan)->count();
        }
        return $stats;
    }
}
