<?php

declare(strict_types=1);

use DragonCode\LastModified\Concerns\Migrations\TableName;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLastModifiedTableAddPrimaryIndex extends Migration
{
    use TableName;

    public function up()
    {
        Schema::table($this->tableName(), function (Blueprint $table) {
            $table->primary('key');
        });
    }

    public function down()
    {
        Schema::table($this->tableName(), function (Blueprint $table) {
            $table->dropPrimary('key');
        });
    }
}
