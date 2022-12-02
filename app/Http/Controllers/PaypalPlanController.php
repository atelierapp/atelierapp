<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\AtelierException;
use App\Http\Requests\PlanSubscriptionRequest;
use App\Http\Resources\PaypalPlanResource;
use App\Models\PaypalPlan;
use App\Services\PaypalService;
use Psr\SimpleCache\InvalidArgumentException;
use Throwable;

class PaypalPlanController extends Controller
{
    public function __construct(
        protected PaypalService $paypalService,
    ) {
    }

    public function index()
    {
        $plans = PaypalPlan::paginate(1000);

        return PaypalPlanResource::collection($plans);
    }

    /**
     * @throws AtelierException
     * @throws Throwable
     * @throws InvalidArgumentException
     */
    public function subscribe(PlanSubscriptionRequest $request, PaypalPlan $plan)
    {
        $response = $this->paypalService->createSubscription($plan->external_plan_id);

        return response()->json(['data' => $response]);
    }
}
