<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:60'],
            'legal_name' => ['required', 'string', 'max:80'],
            'legal_id' => ['required', 'string', 'max:20'],
            'story' => ['required', 'string', 'max:120'],
            'logo' => ['required', 'string'],
            'cover' => ['nullable', 'string'],
            'team' => ['nullable', 'string'],
            'active' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
