<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsImpactColumnToQualityablesTable extends Migration
{
    public function up()
    {
        Schema::table('qualityables', function (Blueprint $table) {
            $table->boolean('is_impact')->default(false);
        });
    }

    public function down()
    {
        Schema::table('qualityables', function (Blueprint $table) {
            $table->dropColumn('is_impact');
        });
    }
}
