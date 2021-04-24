<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['string', 'max:30'],
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
