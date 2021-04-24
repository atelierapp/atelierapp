<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class SocialLoginRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'social_driver' => ['required', 'in:' . \Config::get('social.active_drivers')],
            'social_token' => ['required', 'string', 'min:10'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
