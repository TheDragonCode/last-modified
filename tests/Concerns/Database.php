<?php

declare(strict_types=1);

namespace Tests\Concerns;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

trait Database
{
    protected function db(): Builder
    {
        return DB::connection(
            $this->connection()
        )->table($this->table());
    }
}
