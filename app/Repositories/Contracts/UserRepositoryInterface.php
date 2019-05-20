<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function getUserById($user_id);
    public function basicAuth($email, $password);
    public function otpAuth($mobile);
    public function refreshToken();
    public function generateToken($token, $user);
}
