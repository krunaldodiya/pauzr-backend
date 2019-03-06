<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use OwenMelbz\RadioField\RadioButton;
use Laravel\Nova\Fields\Trix;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Select;
use App\Category;
use App\Store;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;

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
        'id', 'title', 'type', 'start_date', 'expiry_date'
    ];

    public static $with = ['store', 'categories'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $categories = Category::where('parent_id', 0)->pluck('name', 'id');
        $stores = Store::where('type', 'offline')->where(function ($query) use ($request) {
            if (!$request->user()->isAdmin()) {
                $query->where('user_id', $request->user()->id);
            }
        })->pluck('name', 'id');

        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->sortable()
                ->rules('required'),

            Trix::make('Description')
                ->rules('required'),

            RadioButton::make('Coupon Type', 'type')
                ->sortable()
                ->options(['coupon' => 'Coupon', 'discount' => 'Discount'])
                ->default('coupon')
                ->hideWhenUpdating(),

            BelongsToMany::make('Category', 'categories')->searchable(),

            Select::make('Store', 'store_id')->options($stores),

            Text::make('Coupon Code', 'coupon'),

            Avatar::make('Logo'),

            Text::make('Link')->hideFromIndex()->exceptOnForms(),

            Text::make('Aff Link')->hideFromIndex()->exceptOnForms(),

            Date::make('Start Date')
                ->resolveUsing(function ($date) {
                    return $date->format('d/m/Y');
                })
                ->sortable()
                ->rules('required', 'size:10'),

            Date::make('Expiry Date')
                ->resolveUsing(function ($date) {
                    return $date->format('d/m/Y');
                })
                ->sortable()
                ->rules('required', 'size:10')
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->isAdmin()) {
            return true;
        }

        if ($request->user()->isMerchant()) {
            return $query->where('user_id', $request->user()->id);
        }

        return false;
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
