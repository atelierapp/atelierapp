<?php

namespace App\Http\Resources;

use App\Models\Plan;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Plan */
class PlanResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
            'price' => $this->price / 100, // Stored in cents
            'description' => $this->description,
            'stripe_plan_id' => $this->stripe_plan_id,
        ];
    }
}
