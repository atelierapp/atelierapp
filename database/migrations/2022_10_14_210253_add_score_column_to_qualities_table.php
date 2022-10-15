<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoreColumnToQualitiesTable extends Migration
{
    public function up()
    {
        Schema::table('qualities', function (Blueprint $table) {
            $table->double('score', 5,2)->default(0)->after('name');
        });
    }

    public function down()
    {
        Schema::table('qualities', function (Blueprint $table) {
            $table->dropColumn('score');
        });
    }
}
