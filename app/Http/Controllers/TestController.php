<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;

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
        return 'https://api.codemagic.io/artifacts/bccdf913-ea61-4a54-9480-a2754fc3927b/e43efc2d-fd37-438b-ac5d-ceb7929fd8c9/app-release.apk';
    }
}
