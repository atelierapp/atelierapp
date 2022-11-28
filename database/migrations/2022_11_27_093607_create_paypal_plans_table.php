<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaypalPlansTable extends Migration
{
    public function up(): void
    {
        Schema::create('paypal_plans', function (Blueprint $table) {
            $table->id();
            $table->string('external_plan_id');
            $table->string('name');
            $table->string('description');
            $table->string('frequency')->default('MONTH');
            $table->string('currency')->default('usd');
            $table->integer('price');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paypal_plans');
    }
}
