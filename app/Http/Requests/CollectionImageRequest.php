<?php

namespace App\Http\Requests;

use App\Models\Role;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;

class CollectionImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'file', 'image'],
        ];
    }

    public function authorize(): bool
    {
        return Bouncer::is($this->user())->a(Role::SELLER, Role::ADMIN);
    }
}
