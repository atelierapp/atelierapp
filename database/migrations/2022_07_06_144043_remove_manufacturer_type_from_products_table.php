<?php

use App\Enums\ManufacturerTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveManufacturerTypeFromProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('manufacturer_type');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('manufacturer_type', array_keys(ManufacturerTypeEnum::MAP_VALUE));
        });
    }
}
