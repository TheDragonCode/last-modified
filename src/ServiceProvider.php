<?php

namespace DragonCode\LastModified;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->bootMigrations();
        $this->bootPublishes();
    }

    public function register()
    {
        $this->registerConfig();
    }

    protected function bootMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config/last_modified.php' => config_path('last_modified.php'),
        ], 'config');
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/last_modified.php', 'last_modified');
    }
}
