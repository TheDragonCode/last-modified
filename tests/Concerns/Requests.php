<?php

/*
 * This file is part of the "dragon-code/last-modified" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2025 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/last-modified
 */

declare(strict_types=1);

namespace Tests\Concerns;

use Carbon\Carbon;
use Fig\Http\Message\RequestMethodInterface;
use Illuminate\Http\Request;
use Lmc\HttpConstants\Header;

trait Requests
{
    /**
     * @return \Illuminate\Testing\TestResponse
     */
    protected function request(string $url, ?Carbon $date = null)
    {
        if (! empty($date)) {
            $this->withHeader(Header::IF_MODIFIED_SINCE, $date->format('r'));
        }

        return $this->get($url);
    }

    protected function requestInstance(?Carbon $date = null): Request
    {
        $server = ! empty($date) ? $this->getRequestDateHeader($date) : [];

        return Request::create($this->url(), RequestMethodInterface::METHOD_GET, [], [], [], $server);
    }

    protected function getRequestDateHeader(Carbon $date): array
    {
        return ['HTTP_' . Header::IF_MODIFIED_SINCE => $date->format('r')];
    }
}
