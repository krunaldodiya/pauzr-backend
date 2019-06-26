<?php

namespace App\Repositories\Contracts;

interface OtpRepositoryInterface
{
    public function sendOtp($country, $mobile, $otp, $message);
    public function verifyOtp($country, $mobile, $otp);
}
