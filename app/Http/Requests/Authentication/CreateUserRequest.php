<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest {

    public function rules()
    {
        return [
            'first_name'    => ['required', 'string', 'min:2', 'max:80'],
            'last_name'     => ['string', 'min:2', 'max:80'],
            'email'         => ['required', 'unique:users'],
            'username'      => ['required', 'min:5', 'unique:users'],
            'phone'         => ['digits_between:7,14'],
            'password'      => ['required', 'min:6', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'birthday'      => ['date_format:m/d/Y'],
            'is_active'     => ['boolean'],
            'avatar'        => ['url'],
            'social_id'     => ['required_with:social_driver'],
            'social_driver' => ['required_with:social_id', 'in:' . \Config::get('social.active_drivers')],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
