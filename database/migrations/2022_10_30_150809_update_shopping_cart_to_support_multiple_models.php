<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShoppingCartToSupportMultipleModels extends Migration
{
    public function up()
    {
        Schema::table('shopping_cart', function (Blueprint $table) {
            $table->string('customer_type', 30)->default('App\\\Models\\\User')->after('country');
            $table->renameColumn('user_id', 'customer_id');
        });
    }

    public function down()
    {
        Schema::table('shopping_cart', function (Blueprint $table) {
            $table->dropColumn('customer_type');
            $table->renameColumn('customer_id', 'user_id');
        });
    }
}
