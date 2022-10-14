<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class ProductUserQualifyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'score' => ['required', 'int', 'between:1,5'],
            'comment' => ['nullable', 'string'],
            'attaches' => ['nullable'],
            'attaches.*' => ['nullable', 'image'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->isAn(Role::USER);
    }
}
