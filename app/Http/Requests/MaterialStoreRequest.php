<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'image' => ['nullable', 'image'],
            'active' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
