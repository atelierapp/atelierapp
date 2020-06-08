<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('title', 100);
            $table->integer('manufacturer_type')->default(1);
            $table->date('manufactured_at')->nullable();
            $table->longText('description');
            $table->unsignedBigInteger('category_id');
            $table->integer('price');
            $table->integer('quantity')->nullable();
            $table->string('sku')->unique();
            $table->boolean('active')->default(true);
            $table->json('properties')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
