<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'logo' => ['nullable', 'image'],
            'team' => ['nullable', 'image'],
            'cover' => ['nullable', 'image'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->isAn(Role::SELLER);
    }
}
