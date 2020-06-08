<?php

namespace App\Http\Requests;

use App\Enums\ManufacturerTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

class ProductStoreRequest extends FormRequest
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
            'store_id' => ['required', 'exists:stores,id'],
            'title' => ['required', 'string', 'max:100'],
            'manufacturer_type' => ['required', new EnumRule(ManufacturerTypeEnum::class)],
            'manufactured_at' => ['required', 'date_format:m/d/Y'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'price' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'sku' => ['required', 'string', 'unique:products,sku'],
            'active' => 'boolean',
            'properties' => ['required', 'array'],
        ];
    }
}
