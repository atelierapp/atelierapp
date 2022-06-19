<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInternalRatingToStoresTable extends Migration
{
    public function up()
    {
        Schema::table(
            'stores',
            fn (Blueprint $table) => $table->unsignedSmallInteger('internal_rating')->after('customer_rating')->default(0)
        );
    }

    public function down()
    {
        Schema::table(
            'stores',
            fn (Blueprint $table) => $table->dropColumn('internal_rating')
        );
    }
}
