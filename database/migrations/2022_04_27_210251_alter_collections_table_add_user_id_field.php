<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCollectionsTableAddUserIdField extends Migration
{
    public function up()
    {
        Schema::table(
            'collections',
            fn (Blueprint $table) => $table->foreignId('user_id')->nullable()->after('id')->constrained('users')
        );
    }

    public function down()
    {
        Schema::table(
            'collections',
            fn (Blueprint $table) => $table->dropConstrainedForeignId('user_id')
        );
    }
}
