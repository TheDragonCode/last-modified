<?php

declare(strict_types=1);

namespace Tests\Concerns;

use DragonCode\LastModified\Concerns\Urlable as BaseUrl;
use Illuminate\Support\Carbon;

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
