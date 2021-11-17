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

    /**
     * @deprecated Will be deleted since 3.0 version.
     *
     * @return string
     */
    public function databaseConnection(): string
    {
        return config('last_modified.database.connection');
    }

    /**
     * @deprecated Will be deleted since 3.0 version.
     *
     * @return string
     */
    public function databaseTable(): string
    {
        return config('last_modified.database.table');
    }

    public function databaseChunk(): int
    {
        $value = config('last_modified.database.chunk', 1000);

        return $this->getInteger($value, 1000);
    }

    public function cacheTtl(): int
    {
        $value = config('last_modified.cache.ttl', 43200);

        return $this->getInteger($value, 43200);
    }

    public function requestIgnoreKeys(): array
    {
        return config('last_modified.requests.ignore.keys', []);
    }

    protected function getInteger(int $value, int $default): int
    {
        return abs($value) > 1 ? abs($value) : $default;
    }
}
