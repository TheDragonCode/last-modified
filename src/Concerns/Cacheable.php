<?php

declare(strict_types=1);

namespace DragonCode\LastModified\Concerns;

use DragonCode\Cache\Services\Cache;
use DragonCode\LastModified\Facades\Config;

trait Cacheable
{
    protected $cache_tag = 'last_modified';

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
