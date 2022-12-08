<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\AtelierException;
use App\Http\Requests\SubscriptionIntentRequest;
use App\Models\Plan;
use App\Models\Store;
use App\Services\PaypalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Cashier\Cashier;
use Log;
use Throwable;

class SubscriptionController extends Controller
{
    public function __construct(
        protected PaypalService $paypalService,
    ) {
    }

    public function session(SubscriptionIntentRequest $request)
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

    /**
     * @throws Throwable
     */
    public function paypalConfirmation(Request $request)
    {
        $success = $request->query('success');
        $securityToken = $request->query('token');
        $subscriptionId = $request->get('subscription_id');

        $cachedData = Cache::get("paypal-subscriptions:$securityToken", []);

        if (! $success || empty($cachedData)) {
            Cache::forget("paypal-subscriptions:$securityToken");

            Log::warning(__CLASS__ . ': The subscription was cancelled during the process.', [
                'store_id' => $cachedData['store_id'] ?? '',
                'external_subscription_id' => $cachedData['external_subscription_id'] ?? '',
            ]);

            return $this->redirectToVendor(success: false);
        }

        $subscription = $this->paypalService->getSubscription($subscriptionId);

        if ($subscription['status'] !== 'ACTIVE') {
            return $this->redirectToVendor(success: false);
        }

        $store = Store::find($cachedData['store_id']);

        $store->subscription()->create([
            'email' => $subscription['subscriber']['email_address'],
            'paypal_plan_id' => $cachedData['plan_id'],
            'external_subscription_id' => $cachedData['external_subscription_id'],
        ]);

        return $this->redirectToVendor(success: true);
    }

    protected function redirectToVendor(bool $success)
    {
        $success = $success ? 'true' : 'false';

        return redirect()->to(
            sprintf('%s?success=%s', config('atelier.web-app.redirect.stripe.subscription'), $success),
        );
    }
}
