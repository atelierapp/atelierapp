<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class Unit extends Resource
{
    public static $model = \App\Models\Unit::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->rules('required', 'string', 'max:20'),

            Text::make('Class')
                ->rules('required', 'string', 'max:10'),

            Number::make('Factor')
                ->rules('required', 'numeric', 'between:-999.999999999,999.999999999'),

            BelongsTo::make('UnitSystem'),
        ];
    }
}
