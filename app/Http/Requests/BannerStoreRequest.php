<?php

namespace App\Http\Requests;

use App\Models\Banner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BannerStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'order' => ['required', 'numeric'],
            'image' => ['required', 'image'],
            'segment' => ['nullable', 'string', 'max:120'],
            'type' => ['nullable', 'string', Rule::in([Banner::TYPE_POPUP, Banner::TYPE_CAROUSEL])],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
