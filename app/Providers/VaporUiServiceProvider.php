<?php

namespace App\Providers;

use App\Models\Role;
use Bouncer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class VaporUiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->gate();
    }

    /**
     * Register the Vapor UI gate.
     *
     * This gate determines who can access Vapor UI in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewVaporUI', function ($user = null) {
            return Bouncer::is($user)->a(Role::ADMIN);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
