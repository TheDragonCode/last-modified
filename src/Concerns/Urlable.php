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

use DragonCode\LastModified\Facades\Url;
use DragonCode\Support\Helpers\Http\Builder as BuilderService;

trait Urlable
{
    protected function parseUrl($url): BuilderService
    {
        return Url::parse($url);
    }

    protected function hashUrl($url): string
    {
        return Url::hash($url);
    }
}
