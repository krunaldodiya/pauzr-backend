<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Repositories\CouponRepository;
use App\Coupon;

class TestController extends Controller
{
    public $coupon;

    public function __construct(CouponRepository $coupon)
    {
        $this->coupon = $coupon;
    }

    public function test(Request $request)
    {
        return Coupon::with('categories')->first();
    }
}
