<?php

/*
 * This file is part of the "dragon-code/last-modified" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/last-modified
 */

declare(strict_types=1);

namespace Tests;

use DragonCode\LastModified\Concerns\Cacheable;
use DragonCode\LastModified\Middlewares\CheckLastModified;
use DragonCode\LastModified\ServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Concerns\Asserts;
use Tests\Concerns\Fakeable;
use Tests\Concerns\Requests;
use Tests\Concerns\Urlable;
use Tests\fixtures\Providers\TestServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use Cacheable;
    use Fakeable;
    use Asserts;
    use RefreshDatabase;
    use Requests;
    use Urlable;

    protected bool $enabled = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('cache:clear')->run();
    }

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
            ->get('{slug}', static fn (string $slug) => response()->json($slug))->name('slug');
    }

    protected function setConfig($app): void
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('last_modified.chunk', 20);

        $config->set('last_modified.enabled', $this->enabled);

        $config->set('last_modified.requests.ignore.keys', ['qwe', '*led', 'dat*', '*ifi*']);
    }
}
