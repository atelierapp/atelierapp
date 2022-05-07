<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdColumnToStoresTable extends Migration
{
    public function up()
    {
        Schema::table(
            'stores',
            fn(Blueprint $table) => $table->foreignId('user_id')
                ->nullable()->after('id')->constrained('users')
        );
    }

    public function down()
    {
        Schema::table(
            'stores',
            fn(Blueprint $table) => $table->dropColumn('user_id')
        );
    }
}
