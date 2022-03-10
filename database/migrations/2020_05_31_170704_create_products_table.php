<?php

use App\Enums\ManufacturerTypeEnum;
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
        Schema::disableForeignKeyConstraints();

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('title', 100);
            $table->boolean('active')->default(true);
            $table->foreignId('store_id')->constrained();
            $table->enum('manufacturer_type', array_keys(ManufacturerTypeEnum::MAP_VALUE));
            $table->date('manufactured_at')->nullable();
            $table->longText('description')->nullable();
            $table->integer('price');
            $table->foreignId('style_id')->constrained();
            $table->integer('quantity')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
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
