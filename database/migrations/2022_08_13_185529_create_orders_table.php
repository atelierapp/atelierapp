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
            $table->foreignId('store_id')->nullable()->constrained('stores');
            $table->foreignId('seller_id')->nullable()->constrained('users');
            $table->unsignedMediumInteger('items')->default(0);
            $table->decimal('total_price')->default(0);

            $table->unsignedTinyInteger('seller_status')->default(\App\Models\OrderStatus::_SELLER_PENDING);
            $table->timestamp('seller_accepted_on')->nullable();

            $table->string('payment_gateway_code')->nullable();
            $table->unsignedTinyInteger('paid_status')->default(\App\Models\PaymentStatus::PAYMENT_PENDING);
            $table->timestamp('paid_on')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
