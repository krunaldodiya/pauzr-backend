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
}
