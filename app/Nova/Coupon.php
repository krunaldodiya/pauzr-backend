<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use OwenMelbz\RadioField\RadioButton;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Trix;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Date;

class Coupon extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Coupon';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $with = ['store'];

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

            Text::make('Title')
                ->sortable(),

            RadioButton::make('Coupon Type', 'type')
                ->sortable()
                ->options(['coupon' => 'Coupon', 'discount' => 'Discount'])
                ->default('coupon')
                ->hideWhenUpdating(),

            BelongsTo::make("Store")
                ->hideWhenUpdating(),

            Trix::make('Description'),

            Text::make('Coupon Code', 'coupon'),

            Avatar::make('Logo'),

            Text::make('Link')->hideFromIndex(),

            Text::make('Aff Link')->hideFromIndex(),

            Date::make('Start Date'),

            Date::make('Expiry Date')
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
            new DownloadExcel
        ];
    }
}
