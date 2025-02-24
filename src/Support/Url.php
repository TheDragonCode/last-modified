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

namespace DragonCode\LastModified\Support;

use DragonCode\LastModified\Facades\Config as ConfigSupport;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Facades\Http\Builder;
use DragonCode\Support\Http\Builder as HttpBuilder;

class Url
{
    public function parse(string $url): HttpBuilder
    {
        return Builder::parse($url);
    }

    public function hash($url): string
    {
        $uri = $this->parse($url);

        $query = $this->filterQuery($uri);

        $uri->withQuery($query);

        return md5($uri->toUrl());
    }

    protected function filterQuery(HttpBuilder $uri): array
    {
        if ($keys = $this->getIgnoreKeys()) {
            return Arr::of($uri->getQueryArray())
                ->filter(static fn ($key) => ! Str::is($keys, $key), ARRAY_FILTER_USE_KEY)
                ->toArray();
        }

        return [];
    }

    protected function getIgnoreKeys(): array
    {
        return ConfigSupport::requestIgnoreKeys();
    }
}
