<?php

namespace App\Exceptions;

use Exception;

class OtpFailed extends Exception
{
    public function __construct($message = 'Something went wrong')
    {
        parent::__construct($message);
    }
}
