<?php

namespace App\Providers;

use App\Models\SchoolClass;
use App\Policies\SchoolClassPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Gate::policy(SchoolClass::class, SchoolClassPolicy::class);
    }
}