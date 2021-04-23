<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
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
}
