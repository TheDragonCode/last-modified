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

use DragonCode\LastModified\Support\Config as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool disabled()
 * @method static bool enabled()
 * @method static int databaseChunk()
 */
class Config extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Support::class;
    }
}
