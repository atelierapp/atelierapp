<?php

namespace App\Providers;

use App\Models\Ability;
use App\Models\Project;
use App\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Bouncer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Bouncer::useAbilityModel(Ability::class);
        Bouncer::useRoleModel(Role::class);

        Bouncer::ownedVia(Project::class, 'author_id');
    }
}
