<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:30'],
            'image' => 'image',
            'parent_id' => ['integer', 'exists:categories,id'],
            'active' => 'boolean',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

}
