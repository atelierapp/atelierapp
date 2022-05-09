<?php

namespace App\Http\Requests;

use App\Enums\ManufacturerProcessEnum;
use App\Enums\ManufacturerTypeEnum;
use App\Rules\ExistsForSpecifiedAuthenticatedUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'store_id' => ['required', new ExistsForSpecifiedAuthenticatedUser('stores', 'id')],
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
