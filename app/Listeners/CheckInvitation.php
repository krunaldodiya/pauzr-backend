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
        $receiver = $event->user;

        $invitation = Invitation::with('sender')
            ->where(['mobile_cc' => $receiver['mobile_cc']])
            ->orderBy('created_at', 'asc')
            ->first();

        if ($invitation) {
            $sender = $invitation->sender;

            $transaction = $receiver->createTransaction(5, 'deposit', ['description' => "Invited by {$sender->name}"]);
            $receiver->deposit($transaction->transaction_id);

            $transaction = $sender->createTransaction(5, 'deposit', ['description' => "{$receiver->name} accepted invitation"]);
            $sender->deposit($transaction->transaction_id);
        }
    }
}
