<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;

class Media extends Resource
{
    public static $model = \App\Models\Media::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Url')
                ->rules('required', 'string'),

            Code::make('Properties')
                ->rules('json')
                ->json(),

            Boolean::make('Main')
                ->rules('required'),

            BelongsTo::make('Product'),
            BelongsTo::make('Type', 'type', MediaType::class),
        ];
    }
}
