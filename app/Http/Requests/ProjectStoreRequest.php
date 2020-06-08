<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3'],
            'style_id' => ['required', 'integer', 'exists:styles,id'],
            'forked_from' => ['integer', 'exists:projects,id'],
            'published' => 'boolean',
            'public' => 'boolean',
        ];
    }
}
