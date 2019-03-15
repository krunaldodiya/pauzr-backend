<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CouponRepository;
use RobinCSamuel\LaravelMsg91\Facades\LaravelMsg91;

class TestController extends Controller
{
    public $coupon;

    public function __construct(CouponRepository $coupon)
    {
        $this->coupon = $coupon;
    }

    public function test(Request $request)
    {
        return LaravelMsg91::sendOtp("9426726815", 2265, "Your otp for phone verification is 2256");
    }
}
