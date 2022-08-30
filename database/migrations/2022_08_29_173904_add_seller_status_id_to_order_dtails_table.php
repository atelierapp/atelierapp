<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSellerStatusIdToOrderDtailsTable extends Migration
{
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->unsignedTinyInteger('seller_status_id')->default(Order::SELLER_PENDING)->after('total_price');
            $table->text('seller_notes')->nullable()->after('seller_status_id');
        });
    }

    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn([
                'seller_status_id',
                'seller_notes'
            ]);
        });
    }
}
