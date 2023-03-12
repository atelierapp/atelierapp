<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponUsesTable extends Migration
{
    public function up(): void
    {
        Schema::create('coupon_uses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained('coupons');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_uses');
    }
}
