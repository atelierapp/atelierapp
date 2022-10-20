<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignsKeyToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('seller_status_id')->change();
            $table->unsignedBigInteger('paid_status_id')->change();
            $table->foreign('seller_status_id')->on('order_statuses')->references('id');
            $table->foreign('paid_status_id')->on('payment_statuses')->references('id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
