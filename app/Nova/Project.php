<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;

class Project extends Resource
{
    public static $model = \App\Models\Project::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->rules('required', 'string'),

            Boolean::make('Published')
                ->rules('required'),

            Boolean::make('Public')
                ->rules('required'),

            BelongsTo::make('Style'),

            BelongsTo::make('Author', 'author', User::class),

            BelongsTo::make('ForkedFrom', 'forkedFrom', Project::class),

            HasMany::make('Rooms'),
        ];
    }
}
