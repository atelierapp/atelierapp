<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUserRatingFilesTable extends Migration
{
    public function up()
    {
        Schema::create('product_ratings_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_rating_id')->constrained('product_ratings');
            $table->foreignId('type_id')->nullable()->constrained('media_types');
            $table->string('url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_ratings_files');
    }
}
