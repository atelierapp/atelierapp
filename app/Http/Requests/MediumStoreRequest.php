<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediumStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type_id' => ['required', 'integer', 'exists:MediaTypes,id'],
            'url' => ['required', 'string'],
            'properties' => ['json'],
            'main' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
