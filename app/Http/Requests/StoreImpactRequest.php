<?php

namespace App\Http\Requests;

use App\Models\Quality;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreImpactRequest extends FormRequest
{
    public function rules(): array
    {
        $qualities = Quality::all();

        $rules = [
            'qualities' => ['required', 'array', Rule::in($qualities->pluck('id')->toArray())],
        ];

        foreach ($qualities as $quality) {
            $rules[Str::slug($quality->name, '_') . '_file'] = [
                'nullable', 'file'
            ];
        }

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
