<?php

namespace App\Http\Requests\Authentication;

use App\Rules\UsernameRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {

    public function rules()
    {
        return [
            'username' => ['required', new UsernameRule],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
