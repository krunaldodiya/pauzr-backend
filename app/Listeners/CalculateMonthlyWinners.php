<?php

namespace App\Listeners;

use App\Events\SetTimer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Repositories\TimerRepository;

class CalculateMonthlyWinners
{
    public $timerRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TimerRepository $timerRepository)
    {
        $this->timerRepository = $timerRepository;
    }

    /**
     * Handle the event.
     *
     * @param  SetTimer  $event
     * @return void
     */
    public function handle(SetTimer $event)
    {
        $user = User::find($event->timer['user_id']);

        $this->timerRepository->calculateWinners($user, 'Month');
    }
}
