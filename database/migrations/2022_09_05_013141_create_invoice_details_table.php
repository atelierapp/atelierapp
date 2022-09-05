<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('orders');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('variation_id')->constrained('variations');
            $table->decimal('unit_price');
            $table->unsignedMediumInteger('quantity');
            $table->decimal('total_price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_product');
    }
}
