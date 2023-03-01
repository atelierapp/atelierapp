<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountsColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('has_discount')->default(false)->after('price');
            $table->boolean('is_discount_fixed')->nullable()->after('has_discount');
            $table->unsignedBigInteger('discount_amount')->default(0)->after('is_discount_fixed');
            $table->unsignedTinyInteger('final_price')->default(0)->after('discount_amount');
            $table->unsignedBigInteger('discount_percent')->default(0)->after('final_price');
            $table->unsignedBigInteger('discounted_amount')->default(0)->after('discount_percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'has_discount',
                'is_discount_fixed',
                'discount_amount',
                'final_price',
                'discount_percent',
                'discounted_amount',
            ]);
        });
    }
}
