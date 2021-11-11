<?php

declare(strict_types=1);

namespace Tests\Concerns;

use Carbon\Carbon;
use DragonCode\LastModified\Concerns\Urlable as BaseUrl;

trait Urlable
{
    use BaseUrl;

    protected function url(): string
    {
        return 'http://localhost/foo';
    }

    protected function today(): Carbon
    {
        return Carbon::today();
    }

    protected function yesterday(): Carbon
    {
        return Carbon::yesterday();
    }

    protected function tomorrow(): Carbon
    {
        return Carbon::tomorrow();
    }
}
