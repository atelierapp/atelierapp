<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnSellerAcceptedOnToSellerStatusAtOnOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('seller_accepted_on', 'seller_status_at');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('seller_status_at', 'seller_accepted_on');
        });
    }
}
