<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Rules\RequiredAllOrientationImages;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VariationStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:64'],
            'images' => ['required', new RequiredAllOrientationImages()],
            'images.*.file' => ['required', 'file', 'image'],
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
