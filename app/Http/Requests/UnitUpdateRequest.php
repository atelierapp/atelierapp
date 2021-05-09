<?php

namespace App\Http\Requests;

use App\Models\UnitSystem;
use Illuminate\Foundation\Http\FormRequest;

class UnitUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'class' => ['required', 'string', 'max:10'],
            'factor' => ['required', 'numeric', 'between:-999.999999999,999.999999999'],
            'unit_system_id' => ['required', 'integer', 'exists:' . UnitSystem::class . ',id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
