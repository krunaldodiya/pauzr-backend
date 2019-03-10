<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use App\User;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use App\Plan;
use Laravel\Nova\Fields\DateTime;

class PlanSubscription extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\PlanSubscription';

    public static $group = 'Subscription';

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

            Select::make('Plan', 'plan_id')->options(Plan::where('active', true)->pluck('name', 'id')),

            Select::make('User', 'user_id')->options(User::where('is_merchant', true)->pluck('name', 'id')),

            Text::make('Name'),

            Trix::make('Description'),

            Select::make('Subscription Status')->options([
                "active" => "Active",
                "expired" => "Expired",
                "canceled" => "Canceled",
            ]),

            Select::make('Payment Type')->options([
                "cash" => "Cash",
                "card" => "Card",
                "e_wallet" => "E Wallet",
                "net_banking" => "Net Banking"
            ]),

            Select::make('Payment Status')->options([
                "pending" => "Pending",
                "paid" => "Paid",
            ]),

            DateTime::make('Trial Ends At'),

            DateTime::make('Subscription Starts At'),

            DateTime::make('Subscription Ends At'),
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
