<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Events;
use Stancl\Tenancy\Jobs;
use Stancl\Tenancy\Listeners;
use Stancl\Tenancy\Middleware;

class TenancyServiceProvider extends ServiceProvider
{
    public array $events = [
        Events\CreatingTenant::class    => [],
        Events\TenantCreated::class     => [
            Jobs\CreateDatabase::class,
            Jobs\MigrateDatabase::class,
        ],
        Events\SavingTenant::class      => [],
        Events\TenantSaved::class       => [],
        Events\UpdatingTenant::class    => [],
        Events\TenantUpdated::class     => [],
        Events\DeletingTenant::class    => [],
        Events\TenantDeleted::class     => [
            Jobs\DeleteDatabase::class,
        ],
        Events\CreatingDomain::class    => [],
        Events\DomainCreated::class     => [],
        Events\SavingDomain::class      => [],
        Events\DomainSaved::class       => [],
        Events\UpdatingDomain::class    => [],
        Events\DomainUpdated::class     => [],
        Events\DeletingDomain::class    => [],
        Events\DomainDeleted::class     => [],
        Events\InitializingTenancy::class   => [],
        Events\TenancyInitialized::class    => [
            Listeners\BootstrapTenancy::class,
        ],
        Events\EndingTenancy::class         => [],
        Events\TenancyEnded::class          => [
            Listeners\RevertToCentralContext::class,
        ],
        Events\BootstrappingTenancy::class  => [],
        Events\TenancyBootstrapped::class   => [],
        Events\RevertingToCentralContext::class => [],
        Events\RevertedToCentralContext::class  => [],
    ];

    public function register(): void {}

    public function boot(): void
    {
        $this->bootEvents();
        $this->mapRoutes();
        $this->makeTenancyMiddlewareHighestPriority();
    }

    protected function bootEvents(): void
    {
        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                if (is_string($listener) && is_subclass_of($listener, \Illuminate\Contracts\Queue\ShouldQueue::class)) {
                    Event::listen($event, function ($event) use ($listener) {
                        dispatch(new $listener($event->tenant));
                    });
                } else {
                    Event::listen($event, $listener);
                }
            }
        }
    }

  protected function mapRoutes(): void
{
    // if (file_exists(base_path('routes/tenant.php'))) {
    //     Route::group([], base_path('routes/tenant.php'));
    // }
}

    protected function makeTenancyMiddlewareHighestPriority(): void
    {
        $tenancyMiddleware = [
            Middleware\InitializeTenancyByDomain::class,
            Middleware\InitializeTenancyBySubdomain::class,
            Middleware\InitializeTenancyByDomainOrSubdomain::class,
            Middleware\InitializeTenancyByPath::class,
            Middleware\InitializeTenancyByRequestData::class,
        ];

        foreach (array_reverse($tenancyMiddleware) as $middleware) {
            $this->app[\Illuminate\Contracts\Http\Kernel::class]->prependToMiddlewarePriority($middleware);
        }
    }
}