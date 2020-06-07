<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'style_id' => 'required|integer|exists:styles,id',
            'author_id' => 'required|integer|exists:authors,id',
            'forked_from' => 'required',
            'published' => 'required',
            'public' => 'required',
        ];
    }
}
