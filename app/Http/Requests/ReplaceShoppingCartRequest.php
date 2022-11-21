<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplaceShoppingCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            '*.variation_id' => 'exists:variations,id',
            '*.quantity' => 'integer|min:1',
        ];
    }
}
