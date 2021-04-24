<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitSystemStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:15'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

}
