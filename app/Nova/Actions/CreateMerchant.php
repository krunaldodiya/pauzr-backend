<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Http\Request;

class CreateMerchant extends Action implements ShouldQueue
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
        $users->filter(function ($user) {
            $user->merchant()->updateOrCreate(['user_id' => $user->id], ['status' => 'Approved', 'is_active' => true]);
        });
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
        //
    }
}
