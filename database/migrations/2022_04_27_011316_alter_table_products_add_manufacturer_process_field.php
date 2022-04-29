<?php

use App\Enums\ManufacturerProcessEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProductsAddManufacturerProcessField extends Migration
{
    public function up()
    {
        Schema::table(
            'products',
            fn(Blueprint $table) => $table->enum('manufacturer_process', array_keys(ManufacturerProcessEnum::MAP_VALUE))
                ->after('manufacturer_type')
        );
    }

    public function down()
    {
        Schema::table(
            'products',
            fn(Blueprint $table) => $table->dropColumn('manufacturer_process')
        );
    }
}
