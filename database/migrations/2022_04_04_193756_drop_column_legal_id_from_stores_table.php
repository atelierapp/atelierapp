<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnLegalIdFromStoresTable extends Migration
{
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('legal_id');
        });
    }

    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('legal_id', 80);
        });
    }
}
