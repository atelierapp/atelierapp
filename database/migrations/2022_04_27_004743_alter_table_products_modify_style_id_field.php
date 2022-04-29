<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProductsModifyStyleIdField extends Migration
{
    public function up()
    {
        Schema::table(
            'products',
            fn (Blueprint $table) => $table->foreignId('style_id')->change()->nullable()
        );
    }

    public function down()
    {
        //
    }
}
