<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Fields\Select;
use App\PushNotification;
use App\PushNotificationSubscriber;

class SubscribeToPushNotification extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $users)
    {
        $push_notification_id = $fields->push_notification_id;

        $data = $users
            ->map(function ($user) use ($push_notification_id) {
                return [
                    'subscriber_id' => $user->id,
                    'push_notification_id' => $push_notification_id
                ];
            })
            ->toArray();

        PushNotificationSubscriber::insert($data);

        return Action::message('User has been charged 50 points.');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $notifications = PushNotification::pluck('subject', 'id');

        return [
            Select::make('Push Notification', 'push_notification_id')
                ->options($notifications),
        ];
    }
}
