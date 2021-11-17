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

namespace DragonCode\LastModified\Facades;

use DragonCode\LastModified\Support\Url as Support;
use DragonCode\Support\Helpers\Http\Builder;
use Illuminate\Support\Facades\Facade;
use Psr\Http\Message\UriInterface;

/**
 * @method static Builder parse(string $url)
 * @method static string hash(UriInterface|string $url)
 */
class Url extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Support::class;
    }
}
