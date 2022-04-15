<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QualityUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('qualities', 'name')->ignore($this->quality)]
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->isAn(Role::ADMIN);
    }
}
