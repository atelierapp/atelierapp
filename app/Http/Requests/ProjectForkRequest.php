<?php

namespace App\Http\Requests;

use App\Models\Project;
use App\Models\Style;
use Illuminate\Foundation\Http\FormRequest;

class ProjectForkRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'min:3'],
            'style_id' => ['nullable', 'integer', 'exists:' . Style::class . ',id'],
            'forked_from' => ['nullable', 'integer', 'exists:' . Project::class . ',id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
