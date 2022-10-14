<?php

namespace App\Http\Requests;

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
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
