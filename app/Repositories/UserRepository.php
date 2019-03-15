<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\User;

class UserRepository implements UserRepositoryInterface
{
    public function getUserById($user_id)
    {
        return User::with('wallet.transactions')
            ->where(['id' => $user_id])
            ->first();
    }

    public function login($user)
    {
        if (!$token = auth('api')->login($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

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
        $user = User::firstOrCreate(['mobile' => $mobile], $mobile);

        return $this->login($user);
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
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }
}
