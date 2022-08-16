<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('seller_id')->constrained('users');
            $table->unsignedMediumInteger('items')->default(0);
            $table->decimal('total_price')->default(0);
            $table->boolean('is_accepted')->default(false);
            $table->timestamp('accepted_on')->nullable();
            $table->string('payment_gateway_code')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->timestamp('paid_on')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
