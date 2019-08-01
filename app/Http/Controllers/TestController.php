<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use Illuminate\Support\Facades\Storage;

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
        $image = Storage::disk('public')->url("Z8UXQKGI2ELFudYKRrz6Jv52EyU00il5Qh54R3JE.jpeg");

        return $image;
    }
}
