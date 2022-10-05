<?php

namespace App\Http\Resources\User;

use App\Http\Resources\UserSimpleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentGatewayUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user' => UserSimpleResource::make($this->user),
            'payment_gateway' => [
                'id' => $this->payment_gateway_id,
                'name' => 'Paypal'
            ],
            'properties' => $this->properties,
        ];
    }
}
