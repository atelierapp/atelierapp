<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;

class Category extends Resource
{
    public static $model = \App\Models\Category::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->rules('required', 'string', 'max:30'),

            Text::make('Image')
                ->rules('required', 'string'),

            Boolean::make('Active')
                ->rules('required'),

            BelongsTo::make('Parent', 'parent', Category::class),

            HasMany::make('Products'),

            HasMany::make('Categories'),
        ];
    }
}
