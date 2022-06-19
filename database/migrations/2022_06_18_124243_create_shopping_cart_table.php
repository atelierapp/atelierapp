<?php

use App\Models\User;
use App\Models\Variation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingCartTable extends Migration
{
    public function up()
    {
        Schema::create('shopping_cart', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Variation::class);
            $table->integer('quantity')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('shopping_cart');
    }
}
