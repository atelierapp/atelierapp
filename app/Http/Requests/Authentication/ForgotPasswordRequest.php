<?php

namespace App\Http\Requests\Authentication;

use App\Models\User;
use App\Rules\UsernameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ForgotPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['bail', 'required', 'email'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
