<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePaymentStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_gateway_id' => ['required', 'in:1'],
            'email' => ['required_if:payment_gateway_id,1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
