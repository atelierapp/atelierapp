<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionablesTable extends Migration
{
    public function up()
    {
        Schema::create('collectionables', function (Blueprint $table) {
            $table->foreignId('collection_id')->constrained('collections');
            $table->morphs('collectionable');
        });
    }

    public function down()
    {
        Schema::dropIfExists('collectionables');
    }
}
