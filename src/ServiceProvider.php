<?php

namespace Helldar\LastModified;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->publishes([
            __DIR__ . '/config/last_modified.php' => config_path('last_modified.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/last_modified.php', 'last_modified');
    }
}
