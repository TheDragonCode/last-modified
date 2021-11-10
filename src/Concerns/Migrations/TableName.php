<?php

declare(strict_types=1);

namespace DragonCode\LastModified\Concerns\Migrations;

trait TableName
{
    protected function tableName(): string
    {
        return config('last_modified.database.table');
    }
}
