<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:60'],
            'story' => ['required', 'string', 'max:120'],
            'logo' => ['required', 'image'],
            'team' => ['nullable', 'image'],
            'cover' => ['nullable', 'image'],
            'qualities' => ['nullable', 'array', Rule::exists('qualities', 'id')],
            'website' => ['nullable', 'string'],
            // 'legal_name' => ['required', 'string', 'max:80'],
            // 'legal_id' => ['required', 'string', 'max:20'],
            // 'active' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'logo.required' => 'The logo image is required.'
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->isAn(Role::SELLER);
    }
}
