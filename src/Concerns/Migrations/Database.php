<?php

declare(strict_types=1);

namespace DragonCode\LastModified\Concerns\Migrations;

use DragonCode\LastModified\Facades\Config;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

trait Database
{
    protected function connection(): string
    {
        return Config::databaseConnection();
    }

    protected function table(): string
    {
        return Config::databaseTable();
    }

    protected function schema(): Builder
    {
        return Schema::connection($this->connection());
    }
}
