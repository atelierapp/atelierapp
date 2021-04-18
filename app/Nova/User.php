<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\VaporImage;

class User extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @return mixed
     */
    public function title()
    {
        return $this->model()->full_name;
    }

    public function subtitle()
    {
        return "@{$this->username} | {$this->email}";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'first_name', 'last_name', 'email', 'username',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            ID::make()->sortable(),

            VaporImage::make('avatar')
                ->thumbnail(function () {
                    return $this->avatar;
                })
                ->preview(function () {
                    return $this->avatar;
                })
                ->nullable(),

            Text::make('Name', 'full_name')
                ->hideFromDetail()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Text::make('First Name')
                ->hideFromIndex()
                ->rules(['required', 'string', 'min:2', 'max:80']),

            Text::make('Last Name')
                ->hideFromIndex()
                ->rules(['string', 'min:2', 'max:80']),

            Text::make('Username')
                ->sortable()
                ->rules(['required', 'min:5'])
                ->creationRules('unique:users,username')
                ->updateRules('unique:users,username,{{resourceId}}'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:60')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules(['required', 'numeric', 'min:6', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'])
                ->updateRules(['nullable', 'numeric', 'min:6', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'])
                ->nullable(),

            Text::make('Phone')
                ->rules(['string', 'numeric', 'min:7'])
                ->hideFromIndex(),

            Date::make('Birthday')
                ->hideFromIndex()
                ->nullable(),

            Boolean::make('Is Active')
                ->sortable()
                ->rules('boolean')
                ->default(true)
                ->nullable(),

            MorphToMany::make('roles'),

        ];
    }
}
