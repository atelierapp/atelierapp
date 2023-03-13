<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCustomerRatingColumnsInStoresTable extends Migration
{
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->unsignedInteger('customer_rating')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            //
        });
    }
}
