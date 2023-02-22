<?php

namespace App\Http\Requests;

use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => ['required', 'string', 'max:32', 'unique:' . Coupon::class . ',code,' . $this->coupon->id . ',id,deleted_at,NULL'],
            'name' => ['required', 'string', 'max:64', 'unique:' . Coupon::class . ',name,' . $this->coupon->id . ',id,deleted_at,NULL'],
            'description' => ['string'],
            'start_date' => ['date'],
            'end_date' => ['date', 'after_or_equal:start_date'],
            'is_fixed' => ['boolean'],
            'amount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'stock' => ['required', 'integer', 'max:99999'],
            'products.*' => [Rule::exists('products', 'id')],
        ];
    }

    public function authorize()
    {
        return false;
    }
}
