<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class PlanSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAn(Role::SELLER);
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
