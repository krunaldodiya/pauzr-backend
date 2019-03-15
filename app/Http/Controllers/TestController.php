<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CouponRepository;

class TestController extends Controller
{
    public $coupon;

    public function __construct(CouponRepository $coupon)
    {
        $this->coupon = $coupon;
    }

    public function test(Request $request)
    {
        return 'test';
    }
}
