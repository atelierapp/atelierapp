<?php

namespace App\Http\Requests;

use App\Models\Project;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Project|null project
 */
class ProjectUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['string', 'min:3'],
            'style_id' => ['integer', 'exists:styles,id'],
            'published' => 'boolean',
            'public' => 'boolean',
        ];
    }

    public function authorize(): bool
    {
        return Bouncer::can('update', $this->project);
    }

}
