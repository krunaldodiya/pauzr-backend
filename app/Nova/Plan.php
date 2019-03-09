<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Currency;
use Outhebox\NovaHiddenField\HiddenField;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasMany;

class Plan extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Rinvex\Subscriptions\Models\Plan';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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

            HiddenField::make('Currency')
                ->onlyOnForms()
                ->default("INR"),

            HiddenField::make('Invoice Interval')
                ->onlyOnForms()
                ->default("month"),

            HiddenField::make('Trial Interval')
                ->onlyOnForms()
                ->default("day"),

            Text::make('Name'),

            Trix::make('Description'),

            Currency::make('Price')->format('%.2n'),

            Currency::make('Signup Fee')->format('%.2n'),

            Text::make('Trial Days', 'trial_period'),

            Select::make('Plan Duration', 'invoice_period')->options([
                3 => "3 Months",
                6 => "6 Months",
                12 => "12 Months",
            ]),

            HasMany::make('PlanFeatures', 'features')
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
        return [];
    }
}
