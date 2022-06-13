<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsOnDemandColumnToProductsTable extends Migration
{
    public function up()
    {
        Schema::table(
            'products',
            fn (Blueprint $table) => $table->boolean('is_on_demand')->after('quantity')->default(false)
        );
    }

    public function down()
    {
        Schema::table(
            'products',
            fn (Blueprint $table) => $table->dropColumn('is_on_demand')
        );
    }
}
