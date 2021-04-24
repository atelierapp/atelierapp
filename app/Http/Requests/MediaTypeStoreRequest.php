<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaTypeStoreRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'image' => ['string'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
