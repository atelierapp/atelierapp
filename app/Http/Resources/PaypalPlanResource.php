<?php

namespace App\Http\Resources;

use App\Models\PaypalPlan;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PaypalPlan
 */
class PaypalPlanResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'external_plan_id' => $this->external_plan_id,
            'name' => $this->name,
            'description' => $this->description,
            'frequency' => $this->frequency,
            //'currency' => $this->currency,
            'price' => $this->price,
            'active' => $this->active,
        ];
    }
}
