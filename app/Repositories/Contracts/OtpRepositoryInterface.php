<?php

namespace App\Repositories\Contracts;

interface OtpRepositoryInterface
{
    public function sendOtp($mobile, $otp, $message);
    public function verifyOtp($mobile, $otp);
}
