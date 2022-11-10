<?php

namespace App\Http\Requests\Process;

use Illuminate\Foundation\Http\FormRequest;

class ProductProjectUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quantity' => ['integer', 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
