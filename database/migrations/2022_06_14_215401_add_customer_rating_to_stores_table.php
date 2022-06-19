<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerRatingToStoresTable extends Migration
{
    public function up()
    {
        Schema::table(
            'stores',
            fn (Blueprint $table) => $table->unsignedSmallInteger('customer_rating')->after('story')->default(0)
        );
    }

    public function down()
    {
        Schema::table(
            'stores',
            fn (Blueprint $table) => $table->dropColumn('customer_rating')
        );
    }
}
