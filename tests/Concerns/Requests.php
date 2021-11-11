<?php

declare(strict_types=1);

namespace Tests\Concerns;

use Carbon\Carbon;
use Illuminate\Testing\TestResponse;

trait Requests
{
    protected function request(string $url, Carbon $date = null): TestResponse
    {
        if (! empty($date)) {
            $this->withHeader('If-Modified-Since', $date->format('r'));
        }

        return $this->get($url);
    }
}
