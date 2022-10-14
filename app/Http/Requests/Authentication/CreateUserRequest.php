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
            'username' => ['nullable', 'unique:users'],
            'phone' => ['digits_between:7,14'],
            'password' => ['required', 'min:6'],
            'birthday' => ['date_format:m/d/Y'],
            'is_active' => ['boolean'],
            'avatar' => ['url'],
            'social_id' => ['required_with:social_driver'],
            'social_driver' => ['required_with:social_id', 'in:' . \Config::get('social.active_drivers')],
            'role' => ['nullable', Rule::in([Role::SELLER])],
            'locale' => ['required', Rule::in(['en', 'es'])],
            'country' => ['required', Rule::in(['us', 'pe'])],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
