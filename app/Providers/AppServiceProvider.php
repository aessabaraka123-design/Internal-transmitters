<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // تعيين اسم جدول السوبر أدمن لـ Guard منفصل
        \Illuminate\Support\Facades\Auth::provider('super_admin_provider', function ($app, array $config) {
            return new \Illuminate\Auth\EloquentUserProvider(
                $app['hash'],
                \App\Models\SuperAdmin::class
            );
        });
    }
}
