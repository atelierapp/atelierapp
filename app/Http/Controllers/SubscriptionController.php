<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionIntentRequest;
use App\Models\Plan;
use Laravel\Cashier\Cashier;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    public function __invoke(SubscriptionIntentRequest $request)
    {
        /** @var Plan $plan */
        $plan = Plan::firstWhere('stripe_plan_id', request('stripe_plan_id'));

        $session = Cashier::stripe()->checkout->sessions->create([
            'success_url' => config('atelier.web-app.redirect.stripe.subscription.success'),
            'cancel_url' => config('atelier.web-app.redirect.stripe.subscription.failure'),
            'line_items' => [
                [
                    'price' => $plan->stripe_price_id,
                    'quantity' => 1,
                ],
            ],
            'mode' => 'subscription',
        ]);

        return $this->response(
            [
                'session_id' => $session->id,
                'expires_at' => $session->expires_at,
            ],
            __('payment.subscription.intent'),
            Response::HTTP_CREATED,
        );
    }
}
