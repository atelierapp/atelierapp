<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnLogoFromStoresTable extends Migration
{
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('logo')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('logo')->change();
        });
    }
}
