<?php

declare(strict_types=1);

namespace Tests;

use DragonCode\LastModified\Concerns\Migrations\Database;
use DragonCode\LastModified\Middlewares\CheckLastModified;
use DragonCode\LastModified\ServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Concerns\Fakeable;
use Tests\Concerns\Requests;
use Tests\Concerns\Urlable;
use Tests\fixtures\Providers\TestServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use Concerns\Database;
    use Database;
    use Fakeable;
    use RefreshDatabase;
    use Requests;
    use Urlable;

    protected $enabled = true;

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            TestServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $this->setConfig($app);
        $this->setRoutes($app);
    }

    protected function setRoutes($app): void
    {
        /** @var \Illuminate\Routing\Router $router */
        $router = $app['router'];

        $router
            ->middleware(CheckLastModified::class)
            ->get('{slug}', static function (string $slug) {
                return response()->json($slug);
            })->name('slug');
    }

    protected function setConfig($app): void
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('last_modified.database.chunk', 20);

        $config->set('last_modified.enabled', $this->enabled);
    }
}
