<?php

namespace App\Http\Requests\Order;

use App\Models\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'seller_status_id' => ['nullable', Rule::in([
                OrderStatus::_SELLER_PENDING,
                OrderStatus::_SELLER_APPROVAL,
                OrderStatus::_SELLER_REJECT,
                OrderStatus::_SELLER_SEND,
                OrderStatus::_SELLER_IN_TRANSIT,
                OrderStatus::_SELLER_DELIVERED,
            ])],
            'store_id' => ['nullable', 'exists:orders,id'],
            'start_date' => ['nullable', 'date', 'required_with:end_date', 'before_or_equal:end_date'],
            'end_date' => ['nullable', 'date', 'required_with:start_date', 'after_or_equal:start_date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
