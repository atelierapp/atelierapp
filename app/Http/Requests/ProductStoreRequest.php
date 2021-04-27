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
            'properties' => ['required', 'array'],
            'tags.*.name' => ['string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

}
