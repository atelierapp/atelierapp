<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QualityStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('qualities', 'name')],
            'score' => ['required', 'integer', 'between:1,5'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->isAn(Role::ADMIN);
    }
}
