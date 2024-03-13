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

namespace DragonCode\LastModified\Concerns;

use DragonCode\Cache\Services\Cache;
use DragonCode\LastModified\Facades\Config;

trait Cacheable
{
    protected string $cache_tag = 'last_modified';

    protected function cache(string $key): Cache
    {
        return Cache::make()
            ->when($this->cacheEnabled())
            ->ttl($this->cacheTtl())
            ->tags($this->cache_tag)
            ->key($key);
    }

    protected function cacheTtl(): int
    {
        return Config::cacheTtl();
    }

    protected function cacheEnabled(): bool
    {
        return Config::enabled();
    }
}
