<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProjectTable extends Migration
{
    public function up()
    {
        Schema::create('product_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects');
            $table->foreignId('variation_id')->constrained('variations');
            $table->foreignId('product_id')->constrained('products');
            $table->unsignedInteger('quantity')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_project');
    }
}
