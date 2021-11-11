<?php

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
