<?php

namespace App\Http\Requests\Order;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'seller_status_id' => ['nullable', Rule::in([
                Order::_SELLER_PENDING,
                Order::_SELLER_APPROVAL,
                Order::_SELLER_REJECT,
                Order::_SELLER_SEND,
                Order::_SELLER_IN_TRANSIT,
                Order::_SELLER_DELIVERED,
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
