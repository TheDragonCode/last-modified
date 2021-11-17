<?php

declare(strict_types=1);

namespace Tests\Concerns;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Collection;

trait Asserts
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

    protected function assertHasManyCache(Collection $collection, ?Carbon $date = null): void
    {
        $collection->each(function ($item) use ($date) {
            $this->assertHasCache($item->url);

            if (! empty($date)) {
                $this->assertSameDate($date, $item->updated_at);
            }
        });
    }

    protected function assertDoesntManyCache(Collection $collection): void
    {
        $collection->each(function ($item) {
            $this->assertDoesntCache($item->url);
        });
    }

    protected function assertSameDate(?DateTimeInterface $expected, ?DateTimeInterface $actual): void
    {
        $this->assertSame($expected->toIso8601String(), $actual->toIso8601String());
    }
}
