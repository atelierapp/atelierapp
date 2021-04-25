<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\VaporImage;

class Style extends Resource
{
    public static $model = \App\Models\Style::class;

    public static function uriKey()
    {
        return 'id';
    }

    public static $title = 'name';

    public function subtitle()
    {
        return "Code: $this->code";
    }

    public static $search = [
        'id', 'code', 'name',
    ];

    public function fields(Request $request): array
    {
        return [

            ID::make()->sortable(),

            Text::make('Code')
                ->rules('required')
                ->creationRules('unique:styles,code')
                ->updateRules('unique:styles,code,{{resourceId}}'),

            Text::make('Name')
                ->rules(['required', 'min:3']),

            VaporImage::make('Image'),

        ];
    }
}
