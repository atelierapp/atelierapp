<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryColumnToVariationsTable extends Migration
{

    public function up()
    {
        Schema::table('variations', function (Blueprint $table) {
            $table->char('country', 2)->default('')->after('id');
        });
    }

    public function down()
    {
        Schema::table('variations', function (Blueprint $table) {
            $table->dropColumn('country');
        });
    }
}