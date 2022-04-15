<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualityableTable extends Migration
{
    public function up()
    {
        Schema::create('qualityables', function (Blueprint $table) {
            $table->foreignId('quality_id')->constrained('qualities');
            $table->morphs('qualityable');
        });
    }

    public function down()
    {
        Schema::dropIfExists('qualityables');
    }
}
