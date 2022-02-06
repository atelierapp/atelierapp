<?php

namespace App\Http\Requests;

use Bouncer;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property null project
 */
class ProjectImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'image'],
        ];
    }

    public function authorize(): bool
    {
        // return Bouncer::can('update', $this->project); // temporally
        return true;
    }
}
