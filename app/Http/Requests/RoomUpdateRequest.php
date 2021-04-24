<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:50'],
            'dimensions' => ['required', 'array'],
            'doors' => ['array'],
            'windows' => ['array'],
            'framing' => ['required', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

}
