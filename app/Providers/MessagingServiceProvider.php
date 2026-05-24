<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MessagingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(base_path('modules/Messaging/Views'), 'messaging');
    }
}