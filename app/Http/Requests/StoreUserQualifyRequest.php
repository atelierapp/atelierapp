<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserQualifyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'score' => ['required', 'int', 'between:1,5'],
            'comment' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->isAn(Role::USER);
    }
}
