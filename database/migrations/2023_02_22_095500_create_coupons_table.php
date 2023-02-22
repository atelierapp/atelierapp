<?php

use App\Models\Coupon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->string('code', 32)->index();
            $table->string('name', 64);
            $table->text('description')->nullable();
            $table->char('mode', 16)->default(Coupon::TOTAL)->index();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_fixed');
            $table->double('amount', 10, 2);
            $table->unsignedInteger('max_uses')->default(0);
            $table->unsignedInteger('current_uses')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
}
