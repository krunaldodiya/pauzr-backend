<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Trix;
use App\Nova\Actions\DeployPushNotification;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;

class PushNotification extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\PushNotification';

    public static $group = 'PushNotification';

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

            Text::make('Subject')
                ->sortable(),

            Text::make('Title')
                ->sortable(),

            Trix::make('Description')
                ->sortable(),

            Avatar::make('Image'),

            Boolean::make('Status')
                ->sortable()
                ->exceptOnForms(),

            Code::make('Response')
                ->json()
                ->language('javascript')
                ->sortable()
                ->onlyOnDetail()
                ->exceptOnForms(),

            HasMany::make('Push Notification Subscriber', 'subscribers'),
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
            (new DeployPushNotification)
                ->canSee(function ($request) {
                    return $request->user()->isAdmin();
                })
                ->onlyOnDetail(),
        ];
    }
}
