<?php

declare(strict_types=1);

namespace Tests;

use DragonCode\LastModified\Concerns\Migrations\Database;
use DragonCode\LastModified\Middlewares\CheckLastModified;
use DragonCode\LastModified\Models\Model;
use DragonCode\LastModified\ServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Concerns\Requests;
use Tests\Concerns\Urlable;

abstract class TestCase extends BaseTestCase
{
    use Database;
    use RefreshDatabase;
    use Requests;
    use Urlable;

    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $this->setRoutes($app);
    }

    protected function setRoutes($app): void
    {
        $app['router']
            ->middleware(CheckLastModified::class)
            ->get('{slug}', static function (string $slug) {
                return response()->json($slug);
            });
    }

    protected function makeFake(): void
    {
        Model::create([
            'hash'       => $this->hashUrl($this->url()),
            'url'        => $this->url(),
            'updated_at' => $this->today(),
        ]);
    }
}
