<?php

namespace App\Http\Controllers;

use Exception;

use RobinCSamuel\LaravelMsg91\Facades\LaravelMsg91;
use App\Http\Requests\RequestOtp;
use App\Http\Requests\VerifyOtp;
use App\Exceptions\OtpVerificationFailed;
use App\Repositories\UserRepository;

class OtpController extends Controller
{
    public $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    protected function otpAuth($mobile, $otp, $type, $production)
    {
        if ($production) {
            if ($type == 'request') {
                return LaravelMsg91::sendOtp($mobile, $otp, "$otp is Your otp for phone verification.");
            }

            if ($type == 'verify') {
                return LaravelMsg91::verifyOtp($mobile, $otp, ['raw' => true]);
            }
        }

        if ($otp != "1234") {
            throw new OtpVerificationFailed("Invalid OTP");
        }

        return response(['message' => 'otp_verified'], 200);
    }

    public function requestOtp(RequestOtp $request)
    {
        $production = env('APP_ENV') == 'production';

        $mobile = $request->mobile;
        $otp = $production ? mt_rand(1000, 9999) : 1234;

        try {
            $requestOtp = $this->otpAuth($mobile, $otp, 'request', $production);

            return $requestOtp ? ['mobile' => $mobile, 'otp' => $otp] : false;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function verifyOtp(VerifyOtp $request)
    {
        $production = env('APP_ENV') == 'production';

        $mobile = $request->mobile;
        $otp = $request->otp;

        try {
            $verifyOtp = $this->otpAuth($mobile, $otp, 'verify', $production);

            if ($verifyOtp->message == 'otp_verified') {
                return $this->userRepo->otpAuth($mobile);
            } else {
                throw new OtpVerificationFailed($verifyOtp->message);
            }
        } catch (Exception $e) {
            return response(['errors' => ['otp' => [$e->getMessage()]]], 400);
        }
    }
}
