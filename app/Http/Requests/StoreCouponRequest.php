<?php

namespace App\Http\Requests;

use App\Models\Coupon;
use App\Models\Role;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCouponRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'code' => ['required', 'string', 'max:32', 'unique:' . Coupon::class . ',code,NULL,id,deleted_at,NULL'],
            'name' => ['required', 'string', 'max:64', 'unique:' . Coupon::class . ',name,NULL,id,deleted_at,NULL'],
            'description' => ['string'],
            'start_date' => ['date'],
            'end_date' => ['date', 'after_or_equal:start_date'],
            'is_fixed' => ['required', 'boolean'],
            'amount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'max_uses' => ['nullable', 'integer', 'max:99999'],
            'mode' => ['required'],
            'products' => [
                'bail',
                'required_if:mode,' . Coupon::MODE_PRODUCT,
            ],
            'products.*' => [
                'bail',
                'required_if:mode,' . Coupon::MODE_PRODUCT,
                Rule::exists('products', 'id')
            ],
        ];

        $rules['mode'][] = Bouncer::is(auth()->user())->an(Role::SELLER)
            ? Rule::in([Coupon::MODE_SELLER, Coupon::MODE_PRODUCT])
            : Rule::in([Coupon::MODE_TOTAL, Coupon::MODE_INFLUENCER]);

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
