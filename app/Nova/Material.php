<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsToMany;

class Material extends Resource
{
    public static $model = \App\Models\Material::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->rules('required', 'string', 'max:20'),

            Text::make('Image')
                ->rules('string'),

            Boolean::make('Active')
                ->rules('required'),

            BelongsToMany::make('Products'),
        ];
    }
}
