<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsernameValidationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z0-9-_.]+$/'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
