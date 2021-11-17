<?php

declare(strict_types=1);

namespace DragonCode\LastModified\Concerns;

use DragonCode\Cache\Services\Cache;

trait Cacheable
{
    protected function cachePut(string $key, $value): void
    {
        $this->cache($key)->put($value);
    }

    protected function cacheGet(string $key): string
    {
        return $this->cache($key)->get();
    }

    protected function cacheHas(string $key): bool
    {
        return $this->cache($key)->has();
    }

    protected function cacheForget(string $key): void
    {
        $this->cache($key)->forget();
    }

    protected function cache(string $key): Cache
    {
        return Cache::make()
            ->tags('last_modified')
            ->key($key);
    }
}
