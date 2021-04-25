<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsToMany;

class Tag extends Resource
{
    public static $model = \App\Models\Tag::class;

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

            Boolean::make('Active')
                ->rules('required'),

            BelongsToMany::make('Products'),
            BelongsToMany::make('Projects'),
        ];
    }
}
