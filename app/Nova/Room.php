<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsToMany;

class Room extends Resource
{
    public static $model = \App\Models\Room::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->rules('string', 'max:50'),

            Code::make('Dimensions')
                ->rules('required', 'json')
                ->json(),

            Code::make('Doors')
                ->rules('json')
                ->json(),

            Code::make('Windows')
                ->rules('json')
                ->json(),

            Code::make('Framing')
                ->rules('required', 'json')
                ->json(),

            BelongsToMany::make('Products'),
        ];
    }
}
