<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use JD\Cloudder\Facades\Cloudder;

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
        $filename = "https://akm-img-a-in.tosshub.com/indiatoday/images/story/201907/super-30_Hrithik_0-770x433.jpeg?nCjjGiayMRUlj08VebELl_d7Ks7XWxQr";

        Cloudder::upload($filename, null);

        $data = Cloudder::getResult();

        return ['secure_url' => $data['secure_url']];
    }
}
