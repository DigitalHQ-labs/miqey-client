<?php

namespace Libaro\MiQey;

use Illuminate\Support\ServiceProvider;

class MiQeyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
         $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/miqey.php' => config_path('miqey.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/miqey.php', 'miqey');

        $this->app->singleton('miqey', function () {
            return new MiQey;
        });
    }
}
