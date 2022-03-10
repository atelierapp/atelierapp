<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;

class Media extends Resource
{
    public static $model = \App\Models\Media::class;

    public static $title = 'url';

    public static $search = [
        'id',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Type', 'type', MediaType::class),

            Text::make('Url')
                ->rules('required', 'string'),

            Boolean::make('Featured')
                ->rules('required'),

            Select::make('Orientation')->options([
                'front' => 'Front',
                'side' => 'Side',
                'perspective' => 'Perspective',
            ])->displayUsingLabels()->onlyOnForms(),

            MorphTo::make('mediable')
                ->types([Product::class, Project::class])
                ->exceptOnForms(),

            Code::make('Extra')
                ->rules('json')
                ->json(),
        ];
    }
}
