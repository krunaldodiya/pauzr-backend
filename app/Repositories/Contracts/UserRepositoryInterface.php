<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function getUserById($user_id);
}