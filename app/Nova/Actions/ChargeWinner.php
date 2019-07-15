<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Http\Request;

class ChargeWinner extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $onlyOnDetail = true;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $users)
    {
        $success = true;

        foreach ($users as $user) {
            if ($user->wallet->balance >= 50) {
                $transaction = $user->createTransaction(50, 'withdraw', ['description' => "Price Reedem Charges"]);
                $user->withdraw($transaction->transaction_id);
            } else {
                $success = false;
            }
        };

        return $success ? Action::message('User has been charged 50 points.') : Action::danger('Not enough balance');
    }

    public function authorizedToSee(Request $request)
    {
        return $request->user()->isAdmin();
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
