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

class CreateCustomTable extends Migration
{
    use Database;

    public function up()
    {
        $this->schema()->create('custom', function (Blueprint $table) {
            $table->id();

            $table->string('slug');

            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema()->dropIfExists('custom');
    }
}
