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

namespace DragonCode\LastModified;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->bootPublishes();
    }

    public function register()
    {
        $this->registerConfig();
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
