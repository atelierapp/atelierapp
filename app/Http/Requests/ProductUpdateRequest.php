<?php

namespace App\Http\Requests;

use App\Enums\ManufacturerTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

class ProductUpdateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title' => ['string', 'max:100'],
            'manufacturer_type' => new EnumRule(ManufacturerTypeEnum::class),
            'manufactured_at' => 'date_format:m/d/Y',
            'description' => 'string',
            'category_id' => ['integer', 'exists:categories,id'],
            'price' => 'integer',
            'quantity' => 'integer',
            'sku' => ['string', 'unique:products,sku'],
            'active' => 'boolean',
            'properties' => 'array',
        ];
    }

    public function authorize()
    {
        return true;
    }

}
