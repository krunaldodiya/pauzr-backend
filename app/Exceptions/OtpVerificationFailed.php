<?php

namespace App\Exceptions;

use Exception;

class OtpVerificationFailed extends Exception
{
    public function __construct($message = 'Otp verification failed')
    {
        parent::__construct($message);
    }
}
