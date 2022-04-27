<?php

namespace App\Http\Requests;

use App\Models\Role;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;

class CollectionStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return Bouncer::is($this->user())->a(Role::SELLER, Role::ADMIN);
    }
}
