<?php

namespace App\Listeners;

use App\Events\UserWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Invitation;

class CheckInvitation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserWasCreated  $event
     * @return void
     */
    public function handle(UserWasCreated $event)
    {
        $invitation = Invitation::where(['mobile_cc' => $event->user['mobile_cc']])
            ->orderBy('created_at', 'asc')
            ->first();

        dump($invitation);
    }
}
