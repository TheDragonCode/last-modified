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

        return md5($url);
    }
}
