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

use DragonCode\LastModified\Concerns\Migrations\Database;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLastModifiedTableAddUrlColumn extends Migration
{
    use Database;

    public function up()
    {
        Schema::table($this->table(), function (Blueprint $table) {
            $table->text('url')->nullable()->after('key');
        });
    }

    public function down()
    {
        Schema::table($this->table(), function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
}
