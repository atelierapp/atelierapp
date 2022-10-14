<?php

namespace App\Http\Requests\Order;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'seller_status_id' => ['required', Rule::in([
                Order::_SELLER_APPROVAL,
                Order::_SELLER_REJECT,
                Order::_SELLER_SEND,
                Order::_SELLER_IN_TRANSIT,
                Order::_SELLER_DELIVERED,
            ])]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
