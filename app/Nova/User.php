<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use OwenMelbz\RadioField\RadioButton;
use Naif\GeneratePassword\GeneratePassword;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use Laravel\Nova\Fields\Avatar;
use App\Nova\Actions\CreateMerchant;
use Laravel\Nova\Fields\HasMany;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\User';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public function title()
    {
        return $this->name;
    }

    public function subtitle()
    {
        return $this->status ? "Verified" : "Pending";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            GeneratePassword::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8')
                ->length(12),

            Text::make('Mobile')
                ->sortable()
                ->rules('required', 'size:10')
                ->creationRules('unique:users'),

            Date::make('Dob')
                ->resolveUsing(function ($date) {
                    return $date->format('d/m/Y');
                })
                ->rules('required', 'size:10')
                ->hideFromIndex(),

            Avatar::make('Avatar'),

            RadioButton::make('Gender')
                ->options(['Male' => 'Male', 'Female' => 'Female'])
                ->default('Male'),

            Boolean::make('Verified', 'status'),

            Boolean::make('Merchant', 'is_merchant'),

            Boolean::make('Admin', 'is_admin'),

            HasMany::make('Stores'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new DownloadExcel)
                ->onlyOnIndex()
                ->canSee(function ($request) {
                    return $request->user()->isAdmin();
                })
                ->onlyOnIndex(),

            new CreateMerchant
        ];
    }
}
