<?php

/*
 * This file is part of the "dragon-code/last-modified" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/last-modified
 */

declare(strict_types=1);

namespace Tests\Concerns;

use Carbon\Carbon;
use Illuminate\Http\Request;
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

    protected function requestInstance(Carbon $date = null): Request
    {
        $server = ! empty($date)
            ? ['HTTP_If-Modified-Since' => $date->format('r')]
            : [];

        return Request::create($this->url(), 'GET', [], [], [], $server);
    }
}
