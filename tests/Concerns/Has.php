<?php

declare(strict_types=1);

namespace Tests\Concerns;

use Illuminate\Support\Collection;

trait Has
{
    protected function assertHasCache(string $url): void
    {
        $hash = $this->hashUrl($url);

        $this->assertTrue($this->cache($hash)->has());
    }

    protected function assertDoesntCache(string $url): void
    {
        $hash = $this->hashUrl($url);

        $this->assertFalse($this->cache($hash)->has());
    }

    protected function assertHasManyCache(Collection $collection): void
    {
        $collection->each(function ($item) {
            $this->assertHasCache($item->url);
        });
    }

    protected function assertDoesntManyCache(Collection $collection): void
    {
        $collection->each(function ($item) {
            $this->assertDoesntCache($item->url);
        });
    }
}
