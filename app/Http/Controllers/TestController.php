<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CouponRepository;
use Laravel\Socialite\Facades\Socialite;

class TestController extends Controller
{
    public $coupon;

    public function __construct(CouponRepository $coupon)
    {
        $this->coupon = $coupon;
    }

    public function redirectToProvider(Request $request)
    {
        $scopes = [
            'facebook' => ['user_birthday', 'email'],
            'google' => ['profile', 'email'],
        ];

        $driver = $request->driver;
        return Socialite::driver($driver)->scopes($scopes[$driver])->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $driver = $request->driver;
        $user = Socialite::driver($driver)->stateless()->user();

        return view('response', ['user' => $user]);
    }
}
