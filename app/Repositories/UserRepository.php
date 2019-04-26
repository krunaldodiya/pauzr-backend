<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\User;

class UserRepository implements UserRepositoryInterface
{
    public function getUserById($user_id)
    {
        return User::with('location', 'profession')->where(['id' => $user_id])->first();
    }

    protected function register($mobile)
    {
        $authUser = User::create([
            'mobile' => $mobile,
            'password' => bcrypt(str_random(8))
        ]);

        $user = $this->getUserById($authUser->id);

        return $this->login($user);
    }

    protected function login($user)
    {
        $token = auth('api')->tokenById($user->id);

        return $this->generateToken($token, $user);
    }

    public function basicAuth($email, $password)
    {
        $user = User::firstOrCreate(['email' => $email], [
            'email' => $email,
            'password' => $password
        ]);

        return $this->login($user);
    }

    public function otpAuth($mobile)
    {
        $user = User::where(['mobile' => $mobile])->first();

        if ($user) {
            return $this->login($user);
        }

        return $this->register($mobile);
    }

    public function socialAuth($type)
    {
        return $type;
    }

    public function refreshToken()
    {
        return $this->generateToken(auth('api')->refresh(), auth('api')->user());
    }

    public function generateToken($token, $user)
    {
        return [
            'access_token' => $token,
            'user' => $user
        ];
    }
}
