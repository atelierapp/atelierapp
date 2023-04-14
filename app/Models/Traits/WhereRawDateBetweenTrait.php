<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;

trait WhereRawDateBetweenTrait
{
    public function whereRawDateBetween(string $column, array $values, $boolean = 'and')
    {
        $this->whereBetween(DB::raw('DATE(' . $column . ')'), $values, $boolean);

        return $this;
    }

    public function orWhereRawDateBetween(string $column, array $values)
    {
        $this->whereRawDateBetween($column, $values, 'or');

        return $this;
    }
}
