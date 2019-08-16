<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestOtp;
use App\Http\Requests\VerifyOtp;
use App\Repositories\OtpRepository;
use App\Repositories\UserRepository;

class OtpController extends Controller
{
    public $userRepo;
    public $otpRepo;

    public function __construct(UserRepository $userRepo, OtpRepository $otpRepo)
    {
        $this->userRepo = $userRepo;
        $this->otpRepo = $otpRepo;
    }

    public function requestOtp(RequestOtp $request)
    {
        $app_name = config('app.name');
        $production = env('APP_ENV') == 'production';

        $country = $request->country;
        $mobile = $request->mobile;
        $otp = $production ? mt_rand(1000, 9999) : 1234;

        try {
            $requestOtp = $this->otpRepo->sendOtp($country, $mobile, $otp, "$otp is Your otp for phone verification for $app_name.");
            return $requestOtp ? ['mobile' => $mobile, 'otp' => $otp] : false;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function verifyOtp(VerifyOtp $request)
    {
        $country = $request->country;
        $mobile = $request->mobile;
        $otp = $request->otp;

        try {
            $verifyOtp = $this->otpRepo->verifyOtp($country, $mobile, $otp);
            return $verifyOtp ? $this->userRepo->otpAuth($request) : false;
        } catch (Exception $e) {
            return response(['errors' => ['otp' => [$e->getMessage()]]], 400);
        }
    }
}
