<?php

use DragonCode\LastModified\Concerns\Migrations\TableName;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastModifiedTable extends Migration
{
    use TableName;

    public function up()
    {
        Schema::create($this->tableName(), function (Blueprint $table) {
            $table->string('key')->unique();

            $table->timestamp('updated_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->tableName());
    }
}
