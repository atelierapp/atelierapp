<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanResource;
use App\Models\Plan;

class PlanController extends Controller
{
    public function __invoke()
    {
        $plans = Plan::paginate(1000);

        return PlanResource::collection($plans);
    }
}
