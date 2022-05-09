<?php

namespace App\Http\Requests;

use App\Models\Role;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'images' => ['required'],
            'images.*.file' => ['required', 'file'],
            'images.*.orientation' => [
                'required', 'string', 'distinct', Rule::in(['front', 'side', 'perspective', 'plan']),
            ],
        ];
    }

    public function authorize(): bool
    {
        return Bouncer::is($this->user())->a(Role::SELLER, Role::ADMIN);
    }
}
