<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;

class Store extends Resource
{
    public static $model = \App\Models\Store::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->rules('required', 'string', 'max:60'),

            Text::make('Legal name')
                ->rules('required', 'string', 'max:80'),

            Text::make('Legal id')
                ->rules('required', 'string', 'max:20'),

            Text::make('Story')
                ->rules('required', 'string', 'max:120'),

            Text::make('Logo')
                ->rules('required', 'string'),

            Text::make('Cover')
                ->rules('string'),

            Text::make('Team')
                ->rules('string'),

            Boolean::make('Active')
                ->rules('required'),

            HasMany::make('Products'),
            HasMany::make('Users'),
        ];
    }
}
