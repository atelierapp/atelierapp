<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnUsernameFromUsersTable extends Migration
{
    public function up()
    {
        Schema::table(
            'users',
            fn (Blueprint $table) => $table->dropColumn('username')
        );
    }

    public function down()
    {
        Schema::table(
            'users',
            fn (Blueprint $table) => $table->string('username', 60)->unique()
        );
    }
}
