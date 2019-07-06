<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\UserWasCreated;
use App\Events\SetTimer;
use App\Listeners\CalculateWeeklyWinners;
use App\Listeners\CalculateMonthlyWinners;
use App\Listeners\CheckInvitation;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        UserWasCreated::class => [
            CheckInvitation::class,
        ],

        SetTimer::class => [
            CalculateWeeklyWinners::class,
            CalculateMonthlyWinners::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
