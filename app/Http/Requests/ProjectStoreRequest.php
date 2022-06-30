<?php

namespace App\Http\Requests;

use App\Models\Project;
use App\Models\Style;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'style_id' => ['required', 'integer', 'exists:' . Style::class . ',id'],
            'author_id' => ['required', 'exists:' . User::class . ',id'],
            'forked_from_id' => ['nullable', 'integer', 'exists:' . Project::class . ',id'],
            'published' => ['boolean'],
            'public' => ['boolean'],
            'tags.*.name' => ['string'],
            'settings' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
