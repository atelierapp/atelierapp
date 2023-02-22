<?php

namespace App\Http\Requests;

use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCouponRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:32', 'unique:' . Coupon::class . ',code,NULL,id,deleted_at,NULL'],
            'name' => ['required', 'string', 'max:64', 'unique:' . Coupon::class . ',name,NULL,id,deleted_at,NULL'],
            'description' => ['string'],
            'start_date' => ['date'],
            'end_date' => ['date', 'after_or_equal:start_date'],
            'is_fixed' => ['required', 'boolean'],
            'amount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'stock' => ['required', 'integer', 'max:99999'],
            'mode' => ['required', Rule::in([Coupon::TOTAL, Coupon::PRODUCT])],
            'products.*' => ['required_if:mode,' . Coupon::PRODUCT, Rule::exists('products', 'id')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
