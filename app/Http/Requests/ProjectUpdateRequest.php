<?php

namespace App\Http\Requests;

use App\Models\Project;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'min:3'],
            'style_id' => ['integer', 'exists:styles,id'],
            'published' => ['boolean'],
            'public' => ['boolean'],
            'settings' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
        // return Bouncer::can('update', $this->project);
    }
}
