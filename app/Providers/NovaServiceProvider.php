<?php

namespace App\Providers;

use Bouncer;
use GeneaLabs\NovaTelescope\NovaTelescope;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider {

    public function boot(): void
    {
        parent::boot();
    }

    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return Bouncer::is($user)->an('admin');
        });
    }

    protected function cards(): array
    {
        return [
            // TODO: Create cards
        ];
    }

    protected function dashboards(): array
    {
        return [];
    }

    public function tools(): array
    {
        return [
            new NovaTelescope,
        ];
    }

    public function register(): void
    {
        //
    }
}
