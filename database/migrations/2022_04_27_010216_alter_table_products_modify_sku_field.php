<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProductsModifySkuField extends Migration
{
    public function up()
    {
        Schema::table(
            'products',
            fn (Blueprint $table) => $table->string('sku')->change()->nullable()
        );
    }

    public function down()
    {
        //
    }
}
