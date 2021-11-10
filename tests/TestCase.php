<?php

declare(strict_types=1);

namespace Tests;

use Helldar\LastModified\Middlewares\CheckLastModified;
use Helldar\LastModified\ServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->setRoutes($app);
    }

    protected function setRoutes($app)
    {
        $app['router']
            ->middleware(CheckLastModified::class)
            ->get('{slug}', function (string $slug) {
                return response()->json($slug);
            });
    }
}
