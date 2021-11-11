<?php

declare(strict_types=1);

use DragonCode\LastModified\Concerns\Migrations\TableName;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLastModifiedTableAddUrlColumn extends Migration
{
    use TableName;

    public function up()
    {
        Schema::table($this->tableName(), function (Blueprint $table) {
            $table->text('url')->nullable()->after('key');
        });
    }

    public function down()
    {
        Schema::table($this->tableName(), function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
}
