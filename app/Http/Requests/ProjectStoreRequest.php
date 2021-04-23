<?php

namespace App\Http\Requests;

use App\Models\Project;
use App\Models\Style;
use App\Models\User;
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
            'style_id' => ['required', 'integer', 'exists:' . Style::class . ',id'],
            'author_id' => ['required', 'exists:' . User::class . ',id'],
            'forked_from' => ['nullable', 'integer', 'exists:' . Project::class . ',id'],
            'published' => ['boolean'],
            'public' => ['boolean'],
        ];
    }
}
