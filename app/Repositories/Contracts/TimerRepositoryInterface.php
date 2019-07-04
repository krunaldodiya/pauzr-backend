<?php

namespace App\Repositories\Contracts;

interface TimerRepositoryInterface
{
    public function calculateWinners($user, $duration);
}
