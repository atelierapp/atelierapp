<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:60'],
            'story' => ['nullable', 'string', 'max:600'],
            'logo' => ['nullable', 'image'],
            'team' => ['nullable', 'image'],
            'cover' => ['nullable', 'image'],
            'qualities' => ['nullable', 'array', Rule::exists('qualities', 'id')],
            'website' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->isAn(Role::SELLER);
    }
}
