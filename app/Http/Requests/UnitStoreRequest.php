<?php

namespace App\Http\Requests;

use App\Models\UnitSystem;
use Illuminate\Foundation\Http\FormRequest;

class UnitStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'class' => ['required', 'string', 'max:10'],
            'factor' => ['required', 'numeric', 'between:-999.999999999,999.999999999'],
            'unit_system_id' => ['required', 'integer', 'exists:' . UnitSystem::class . ',id'],
        ];
    }
}
