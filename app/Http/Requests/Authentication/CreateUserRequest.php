<?php

namespace App\Http\Requests\Authentication;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2', 'max:80'],
            'last_name' => ['string', 'min:2', 'max:80'],
            'email' => ['required', 'email', 'unique:users'],
            'username' => ['required', 'min:3', 'unique:users', 'regex:/^[a-zA-Z0-9-_.]+$/'],
            'phone' => ['digits_between:7,14'],
            'password' => ['required', 'min:6'],
            'birthday' => ['date_format:m/d/Y'],
            'is_active' => ['boolean'],
            'avatar' => ['url'],
            'social_id' => ['required_with:social_driver'],
            'social_driver' => ['required_with:social_id', 'in:' . \Config::get('social.active_drivers')],
            'role' => ['nullable', Rule::in([Role::SELLER])]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
