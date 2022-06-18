<?php

namespace App\Http\Requests;

use App\Models\Role;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;

class SubscriptionIntentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stripe_plan_id' => ['required', 'exists:plans'],
        ];
    }
}
