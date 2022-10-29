<?php

namespace App\Http\Requests\Process;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductProjectStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'variation_id' => ['required', Rule::exists('variations', 'id')],
            'quantity' => ['integer', 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
