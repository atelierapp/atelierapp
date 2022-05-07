<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDuplicatedColumnToVariationsTable extends Migration
{
    public function up()
    {
        Schema::table(
            'variations',
            fn(Blueprint $table) => $table->boolean('is_duplicated')->default(false)->after('name')
        );
    }

    public function down()
    {
        Schema::table(
            'variations',
            fn(Blueprint $table) => $table->dropColumn('is_duplicated')
        );
    }
}
