<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['string', 'max:80'],
            'last_name' => ['string', 'max:80'],
            'email' => ['email', 'max:60'],
            'phone' => ['string', 'max:14'],
            'birthday' => ['date'],
        ];
    }
}
