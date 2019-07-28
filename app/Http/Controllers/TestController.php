<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use JD\Cloudder\Facades\Cloudder;
use App\Quote;
use Illuminate\Support\Arr;

class TestController extends Controller
{
    public $userRepository;
    public $timerRepository;

    public function __construct(UserRepository $userRepository, TimerRepository $timerRepository)
    {
        $this->userRepository = $userRepository;
        $this->timerRepository = $timerRepository;
    }

    public function check(Request $request)
    {
        $quotes = Quote::orderBy('order', 'asc')->get();

        $first_array = $quotes[0];

        unset($quotes[0]);

        $other_quotes = array_values($quotes->toArray());

        $shuffled_quotes = Arr::shuffle($other_quotes);

        $random_quotes = array_merge([$first_array->toArray()], $shuffled_quotes);

        return ['quotes' => $random_quotes];
    }
}
