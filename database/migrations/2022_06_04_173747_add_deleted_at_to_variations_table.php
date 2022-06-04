<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToVariationsTable extends Migration
{
    public function up()
    {
        Schema::table(
            'variations',
            fn (Blueprint $table) => $table->softDeletes()->after('updated_at')
        );
    }

    public function down()
    {
        Schema::table(
            'variations',
            fn (Blueprint $table) => $table->dropColumn('deleted_at')
        );
    }
}
