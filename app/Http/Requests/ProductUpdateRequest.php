<?php

namespace App\Http\Requests;

use App\Enums\ManufacturerProcessEnum;
use App\Rules\ExistsForSpecifiedAuthenticatedUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'store_id' => ['required', new ExistsForSpecifiedAuthenticatedUser('stores', 'id')],

            'title' => ['required', 'string', 'max:100'],
            'active' => ['boolean'],
            'qualities' => ['required', 'array', Rule::exists('qualities', 'id')],
            'manufacturer_process' => ['required', Rule::in(array_keys(ManufacturerProcessEnum::MAP_VALUE))],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'collections.*.name' => ['nullable', 'string'],
            'description' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'numeric'],
            'quantity' => ['integer'],
            'is_on_demand' => ['nullable', 'boolean'],
            'is_unique' => ['nullable', 'boolean'],
            'sku' => ['string', 'unique:products,sku'],

            'depth' => ['nullable', 'integer'],
            'height' => ['nullable', 'integer'],
            'width' => ['nullable', 'integer'],

            'tags' => ['required'],
            'tags.*.name' => ['required_with:tags', 'string'],
            'materials' => ['required'],
            'materials.*.name' => ['required_with:materials', 'string'],

            'has_discount' => ['nullable', 'boolean'],
            'is_discount_fixed' => [
                'boolean',
                Rule::requiredIf(function (){
                    return $this->has_discount == true || $this->has_discount == 1;
                })
            ],
            'discount_amount' => [
                Rule::requiredIf(function (){
                    return $this->has_discount == true || $this->has_discount == 1;
                }),
            ]
        ];

        if (!$this->is_discount_fixed && $this->has_discount) {
            $rules['discount_amount'][] = 'numeric';
            $rules['discount_amount'][] = 'max:100';
        }

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
