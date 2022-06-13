<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsUniqueColumnToProductsTable extends Migration
{
    public function up()
    {
        Schema::table(
            'products',
            fn (Blueprint $table) => $table->boolean('is_unique')->after('is_on_demand')->default(false)
        );
    }

    public function down()
    {
        Schema::table(
            'products',
            fn (Blueprint $table) => $table->dropColumn('is_unique')
        );
    }
}
