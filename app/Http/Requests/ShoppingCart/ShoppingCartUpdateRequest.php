<?php

namespace App\Http\Requests\ShoppingCart;

use Illuminate\Foundation\Http\FormRequest;

class ShoppingCartUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'variation_id' => ['required', 'exists:variations,id'],
            'quantity' => ['required'],
            'price' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true; // TODO
    }
}
