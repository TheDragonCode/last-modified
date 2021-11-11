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
