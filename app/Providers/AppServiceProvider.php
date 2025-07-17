<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::useAggressivePrefetching();

        if ($this->app->isProduction()) {
            $this->app['request']->server->set('HTTPS', 'on');
            URL::forceScheme('https');
        } else {
            URL::forceScheme('http');
        }
    }
}
