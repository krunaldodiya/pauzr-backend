<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

use App\Timer;

class SetTimer
{
    use Dispatchable, SerializesModels;

    public $timer;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Timer $timer)
    {
        $this->timer = $timer;
    }
}
