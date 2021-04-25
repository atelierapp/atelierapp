<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Product extends Resource
{
    public static $model = \App\Models\Product::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->rules('required', 'string', 'max:100'),

            Number::make('Manufacturer type')
                ->rules('required', 'integer'),

            Date::make('Manufactured at')
                ->rules('date'),

            Textarea::make('Description')
                ->rules('required', 'string'),

            Number::make('Price')
                ->rules('required', 'integer'),

            Number::make('Quantity')
                ->rules('integer'),

            Text::make('Sku')
                ->rules('required', 'string', 'unique:products,sku'),

            Boolean::make('Active')
                ->rules('required'),

            Code::make('Properties')
                ->rules('json')
                ->json(),

            BelongsToMany::make('Tags'),
            BelongsToMany::make('Materials'),
            BelongsToMany::make('Categories'),

            MorphMany::make('Media', 'medias', Media::class),
        ];
    }
}
