<?php

declare(strict_types=1);

use DragonCode\LastModified\Concerns\Migrations\Database;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeLastModifiedTableAddUrlColumn extends Migration
{
    use Database;

    public function up()
    {
        $this->schema()->table($this->table(), function (Blueprint $table) {
            $table->text('url')->nullable()->after('key');
        });
    }

    public function down()
    {
        $this->schema()->table($this->table(), function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
}
