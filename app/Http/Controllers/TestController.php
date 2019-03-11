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
            'facebook' => ['public_profile', 'email'],
            'google' => [
                'https://www.googleapis.com/auth/plus.me',
                'https://www.googleapis.com/auth/plus.login',
                'https://www.googleapis.com/auth/plus.profile.emails.read'
            ],
        ];

        $driver = $request->driver;
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $driver = $request->driver;
        $user = Socialite::driver($driver)->stateless()->user();

        return view('response', ['user' => $user]);
    }
}
