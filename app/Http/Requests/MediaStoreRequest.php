<?php

namespace App\Http\Requests;

use App\Models\MediaType;
use Illuminate\Foundation\Http\FormRequest;

class MediaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type_id' => ['required', 'exists:' . MediaType::class . ',id'],
            'url' => ['url'],
            'properties' => ['array'],
            'main' => ['boolean'],
        ];
    }
}
