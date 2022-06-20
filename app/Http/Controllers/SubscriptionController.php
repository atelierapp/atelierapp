<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionIntentRequest;
use App\Models\Plan;
use Laravel\Cashier\Cashier;

class SubscriptionController extends Controller
{
    public function __invoke(SubscriptionIntentRequest $request)
    {
        /** @var Plan $plan */
        $plan = Plan::firstWhere('stripe_plan_id', request('stripe_plan_id'));

        $session = Cashier::stripe()->checkout->sessions->create([
            'customer' => (auth()->user())->stripe_id,
            'success_url' => config('atelier.web-app.redirect.stripe.subscription') . '?success=true',
            'cancel_url' => config('atelier.web-app.redirect.stripe.subscription') . '?success=false',
            'line_items' => [
                [
                    'price' => $plan->stripe_price_id,
                    'quantity' => 1,
                ],
            ],
            'mode' => 'subscription',
        ]);

        return $this->response([
            'redirect_url' => $session->url,
        ]);
    }
}
