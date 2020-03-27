<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use OwenMelbz\RadioField\RadioButton;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\HasMany;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outhebox\NovaHiddenField\HiddenField;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Boolean;
use App\Nova\Lenses\TopBrands;

class Store extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Store';

    public static $group = 'Merchant';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'type', 'city'
    ];

    public static $with = ['user'];

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

            BelongsTo::make("Category")->hideWhenUpdating(),

            Avatar::make('Logo'),

            Text::make('Name'),

            RadioButton::make('Store Type', 'type')
                ->options(['offline' => 'Offline', 'online' => 'Online'])
                ->default('offline')
                ->canSee(function ($request) {
                    return $request->user()->isAdmin();
                })
                ->sortable(),

            Trix::make('Description'),

            Place::make('City')->onlyCities()->countries(['IN'])->sortable(),

            Text::make('Website')->withMeta(['placeholder' => 'https://www.google.com']),

            Text::make('Facebook')->withMeta(['placeholder' => 'https://www.facebook.com']),

            Text::make('Instagram')->withMeta(['placeholder' => 'https://www.instagram.com']),

            Text::make('Twitter')->withMeta(['placeholder' => 'https://www.twitter.com']),

            Boolean::make('Top Brand', 'top_brand')->sortable(),

            Text::make('Sort Order')->sortable(),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->isAdmin()) {
            return true;
        }

        return $query->whereHas('user', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        });
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
        return [
            new TopBrands
        ];
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
