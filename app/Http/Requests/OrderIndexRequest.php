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
                Order::SELLER_PENDING,
                Order::SELLER_APPROVAL,
                Order::SELLER_REJECT,
            ])]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
