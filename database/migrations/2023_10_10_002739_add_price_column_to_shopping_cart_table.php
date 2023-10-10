<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceColumnToShoppingCartTable extends Migration
{
    public function up()
    {
        Schema::table('shopping_cart', function (Blueprint $table) {
            $table->unsignedBigInteger('price')->default(0);
        });

        DB::select(DB::raw("update shopping_cart a, variations b, products c set a.price = c.price where a.variation_id = b.id and b.product_id = c.id;"));
    }

    public function down()
    {
        Schema::table('shopping_cart', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
}
