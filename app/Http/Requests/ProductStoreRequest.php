<?php

namespace App\Http\Requests;

use App\Enums\ManufacturerProcessEnum;
use App\Enums\ManufacturerTypeEnum;
use App\Models\Role;
use App\Rules\RequiredAllOrientationImages;
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
            'collections.*.name' => ['nullable', 'string'],
            'description' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'is_on_demand' => ['nullable', 'boolean'],
            'is_unique' => ['nullable', 'boolean'],
            'sku' => ['nullable', 'string', 'unique:products,sku'],

            'images' => ['required', new RequiredAllOrientationImages()],
            'images.*.file' => ['required', 'file'],
            'images.*.orientation' => ['required', 'string', 'distinct', Rule::in(['front', 'side', 'perspective', 'plan'])],
            'depth' => ['required', 'integer'],
            'height' => ['required', 'integer'],
            'width' => ['required', 'integer'],

            'tags' => ['required'],
            'tags.*.name' => ['required_with:tags', 'string'],
            'materials' => ['required'],
            'materials.*.name' => ['required_with:materials', 'string'],

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
