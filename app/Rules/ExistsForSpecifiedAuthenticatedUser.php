<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ExistsForSpecifiedAuthenticatedUser implements Rule
{
    public function __construct(private string $table, private string $column)
    {
        //
    }

    public function passes($attribute, $value): bool
    {
        return (boolean) DB::table($this->table)
            ->where($this->column, '=', $value)
            ->where('user_id', '=', auth()->id())
            ->count();
    }

    public function message(): string
    {
        $messages = [
            'es' => 'La tienda solicitada es incorrecta.',
            'en' => 'The selected store is invalid.',
        ];

        return $messages[app()->getLocale()];
    }
}
