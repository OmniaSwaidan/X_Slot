<?php

namespace Omniax\X_slot;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


class XslotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    public function register(): void
    {
        include __DIR__ . '/routes/web.php';
        // $this->app->singleton(knet::class, function ($app) {
        //     return new knet();
        // });
        // $this->app->bind(PaymentRepository::class, function ($app) {
        //     return new PaymentRepository(new Payment());
        // });

    }

    /**
     * Bootstrap services.
     */

    public function boot(): void
    {

        // Load views from the package
        $this->loadViewsFrom(__DIR__ . '/views', 'X_slot');

        // Load migrations from the package
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Publish views
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/X_slot'),
        ]);

        // Publish migrations
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'migrations');

        // Publish requests (if any)
        $this->publishes([
            __DIR__ . '/Requests' => app_path('Http/Requests/X_slot'),
        ], 'XslotRequest');

        Blade::component('layout', \Omniax\X_slot\View\Components\Layout::class);
    }
}
