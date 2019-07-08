<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\TimerRepository;
use App\User;
use Illuminate\Support\Arr;

class AddTimer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timer:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate timer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(TimerRepository $timerRepository)
    {
        $mobiles = ['9426726815', '7016342489', '7795180333', '8073798640'];

        $user = User::inRandomOrder()
            ->whereIn('mobile', $mobiles)
            ->first();

        $items = Arr::random(["20", "40", "60"], 1);

        $duration = $items[0];

        $timerRepository->setTimer($user, $duration);
    }
}
