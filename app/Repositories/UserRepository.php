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
        if (!$token = auth('api')->attempt($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->_respondWithToken($token, $user);
    }

    public function register($data)
    {
        return User::firstOrCreate(['email' => $data['email']], $data);
    }

    public function refreshToken()
    {
        return $this->_respondWithToken(auth('api')->refresh(), auth('api')->user());
    }

    protected function _respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }
}
