<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSocialAccountsTable extends Migration
{
    public function up()
    {
        \Schema::create('social_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('driver');
            $table->foreignId('user_id');
            $table->string('social_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        \Schema::dropIfExists('social_accounts');
    }
}
