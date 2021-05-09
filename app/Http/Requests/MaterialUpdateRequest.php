<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'image' => ['string'],
            'active' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
