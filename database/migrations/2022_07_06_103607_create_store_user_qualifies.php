<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreUserQualifies extends Migration
{
    public function up()
    {
        Schema::create('store_user_qualifies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('store_id')->references('id')->on('stores');
            $table->unsignedSmallInteger('score')->default(0);
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('store_user_qualifies');
    }
}
