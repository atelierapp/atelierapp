<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Project|null project
 */
class ProjectDeleteRequest extends FormRequest
{

    public function rules(): array
    {
        return [];
    }

    public function authorize()
    {
        return $this->user()->can('delete', $this->project);
    }

}
