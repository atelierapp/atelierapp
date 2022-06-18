<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanResource;
use App\Models\Plan;

class PlanController extends Controller
{
    public function __invoke()
    {
        $plans = Plan::paginate();

        return PlanResource::collection($plans);
    }
}
