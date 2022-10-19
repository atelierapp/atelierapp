<?php

namespace App\Http\Requests\Order;

use App\Models\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'seller_status_id' => ['required', Rule::in([
                OrderStatus::_SELLER_APPROVAL,
                OrderStatus::_SELLER_REJECT,
                OrderStatus::_SELLER_SEND,
                OrderStatus::_SELLER_IN_TRANSIT,
                OrderStatus::_SELLER_DELIVERED,
            ])]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
