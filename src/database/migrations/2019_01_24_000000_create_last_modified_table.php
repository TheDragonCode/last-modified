<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastModifiedTable extends Migration
{
    protected $table = 'last_modified';

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->string('key')->unique();

            $table->timestamp('updated_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
