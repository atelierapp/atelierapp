<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaTypeUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'image' => ['string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
