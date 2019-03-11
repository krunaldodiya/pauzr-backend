<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function getUserById($user_id);
    public function register($data);
    public function refreshToken();
}