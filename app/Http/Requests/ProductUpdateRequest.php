<?php

namespace App\Http\Requests;

use App\Enums\ManufacturerTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
}
