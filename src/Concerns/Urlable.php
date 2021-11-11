<?php

declare(strict_types=1);

namespace DragonCode\LastModified\Concerns;

use DragonCode\Support\Facades\Http\Builder;
use DragonCode\Support\Helpers\Http\Builder as BuilderService;

trait Urlable
{
    protected function parseUrl($url): BuilderService
    {
        return Builder::parse($url);
    }

    protected function hashUrl($uri): string
    {
        $url = $this->parseUrl($uri)->toUrl();

        return md5(trim($url));
    }
}
