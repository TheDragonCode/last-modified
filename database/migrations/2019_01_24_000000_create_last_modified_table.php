<?php

use DragonCode\LastModified\Concerns\Migrations\Database;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLastModifiedTable extends Migration
{
    use Database;

    public function up()
    {
        $this->schema()->create($this->table(), function (Blueprint $table) {
            $table->string('key')->unique();

            $table->timestamp('updated_at');
        });
    }

    public function down()
    {
        $this->schema()->dropIfExists($this->table());
    }
}
