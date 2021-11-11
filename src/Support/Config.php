<?php

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

    public function databaseConnection(): string
    {
        return config('last_modified.database.connection');
    }

    public function databaseTable(): string
    {
        return config('last_modified.database.table');
    }

    public function databaseChunk(): int
    {
        $value = config('last_modified.database.chunk', 1000);

        return abs($value) > 1 ? abs($value) : 1000;
    }
}
