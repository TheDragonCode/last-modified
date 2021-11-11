<?php

declare(strict_types=1);

namespace DragonCode\LastModified\Facades;

use DragonCode\LastModified\Support\Config as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool disabled()
 * @method static bool enabled()
 * @method static int databaseChunk()
 * @method static string databaseConnection()
 * @method static string databaseTable()
 */
class Config extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Support::class;
    }
}
