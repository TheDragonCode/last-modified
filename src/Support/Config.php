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

namespace DragonCode\LastModified\Support;

use DragonCode\Support\Facades\Helpers\Boolean;

class Config
{
    public function enabled(): bool
    {
        $value = config('last_modified.enabled');

        return Boolean::isTrue($value);
    }

    public function disabled(): bool
    {
        return ! $this->enabled();
    }

    public function databaseChunk(): int
    {
        $value = config('last_modified.database.chunk', 1000);

        return abs($value) > 1 ? abs($value) : 1000;
    }

    public function cacheTtl(): int
    {
        $value = config('last_modified.cache.ttl', 1440);

        return abs($value) > 1 ? abs($value) : 1440;
    }
}
