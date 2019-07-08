<?php

namespace App\Repositories\Contracts;

interface TimerRepositoryInterface
{
    public function setTimer($user, $duration);
    public function calculateWinners($user, $period);
}
