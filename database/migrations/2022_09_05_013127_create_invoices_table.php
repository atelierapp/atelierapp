<?php

use App\Models\Invoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('store_id')->nullable()->constrained('stores');
            $table->foreignId('seller_id')->nullable()->constrained('users');
            $table->unsignedMediumInteger('items')->default(0);
            $table->decimal('total_price')->default(0);

            $table->string('payment_gateway_code')->nullable();
            $table->unsignedTinyInteger('paid_status_id')->default(Invoice::PAYMENT_PENDING);
            $table->timestamp('paid_on')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
