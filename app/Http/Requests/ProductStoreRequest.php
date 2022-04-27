<?php

namespace App\Http\Requests;

use App\Enums\ManufacturerProcessEnum;
use App\Enums\ManufacturerTypeEnum;
use App\Models\Role;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'store_id' => ['required', 'exists:stores,id'],

            'title' => ['required', 'string', 'max:100'],
            'manufacturer_type' => ['required', Rule::in(array_keys(ManufacturerTypeEnum::MAP_VALUE))],
            'manufacturer_process' => ['required', Rule::in(array_keys(ManufacturerProcessEnum::MAP_VALUE))],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'collections.*.id' => ['nullable', Rule::exists('collections', 'id')],
            'description' => ['required', 'string', 'max:1000'],
            'tags.*.name' => ['nullable', 'string'],
            'materials.*.name' => ['nullable', 'string'],
            'price' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'is_on_demand' => ['nullable', 'boolean'],
            'is_unique' => ['nullable', 'boolean'],
            'sku' => ['nullable', 'string', 'unique:products,sku'],

            'images.*.file' => ['nullable', 'file'],
            'images.*.orientation' => ['nullable', 'string', Rule::in('front', 'perspective', 'side', 'plan')],
            'depth' => ['required_with:attach.*.file', 'integer'],
            'height' => ['required_with:attach.*.file', 'integer'],
            'width' => ['required_with:attach.*.file', 'integer'],


            // 'manufactured_at' => ['required', 'date_format:m/d/Y'],
            // 'style_id' => ['required', 'exists:styles,id'],
            // 'properties' => ['required', 'array'],
            // 'url' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return Bouncer::is($this->user())->a(Role::SELLER, Role::ADMIN);
    }
}
