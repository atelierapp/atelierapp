<?php

namespace App\Http\Requests;

use App\Models\MediaType;
use Illuminate\Foundation\Http\FormRequest;

class MediaUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'type_id' => ['required', 'exists:' . MediaType::class . ',id'],
            'url' => ['url'],
            'properties' => ['array'],
            'featured' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
