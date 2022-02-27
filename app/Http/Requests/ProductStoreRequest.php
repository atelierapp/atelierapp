<?php

namespace App\Http\Requests;

use App\Enums\ManufacturerTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

class ProductStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'manufacturer_type' => ['required', new EnumRule(ManufacturerTypeEnum::class)],
            'manufactured_at' => ['required', 'date_format:m/d/Y'],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'sku' => ['required', 'string', 'unique:products,sku'],
            'active' => ['boolean'],
            'style_id' => ['required', 'exists:styles,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'properties' => ['required', 'array'],
            'url' => ['nullable', 'string'],
            'tags.*.name' => ['nullable', 'string'],
            'attach.*.file' => ['nullable', 'file'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
