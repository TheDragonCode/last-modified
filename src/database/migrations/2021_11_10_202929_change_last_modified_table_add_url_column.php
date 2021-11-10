<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLastModifiedTableAddUrlColumn extends Migration
{
    protected $table = 'last_modified';

    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->text('url')->nullable()->after('key');
        });
    }

    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
}
