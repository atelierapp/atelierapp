<?php

namespace App\Http\Requests;

use App\Enums\ManufacturerProcessEnum;
use App\Enums\ManufacturerTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Enum\Laravel\Rules\EnumRule;

class ProductUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'manufacturer_type' => ['required', Rule::in(array_keys(ManufacturerTypeEnum::MAP_VALUE))],
            'manufacturer_process' => ['required', Rule::in(array_keys(ManufacturerProcessEnum::MAP_VALUE))],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'description' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'integer'],

            'tags' => ['required'],
            'tags.*.name' => ['required_with:tags', 'string'],
            'materials' => ['required'],
            'materials.*.name' => ['required_with:materials', 'string'],

            'manufactured_at' => 'date_format:m/d/Y',
            'style_id' => ['integer', 'exists:styles,id'],
            'store_id' => ['integer', 'exists:stores,id'],
            'quantity' => ['integer'],
            'sku' => ['string', 'unique:products,sku'],
            'active' => ['boolean'],

            'collections.*.name' => ['nullable', 'string'],

            // 'properties' => ['array'],
            // 'url' => ['nullable', 'string'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
