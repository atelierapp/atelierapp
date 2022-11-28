<?php

use App\Models\PaypalPlan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaypalSubscriptionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('paypal_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->morphs('subscribable');
            $table->string('email');
            $table->string('external_subscription_id');
            $table->foreignIdFor(PaypalPlan::class)->constrained();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('paypal_subscriptions');
    }
}
