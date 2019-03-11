<?php

namespace App\Http\Controllers\Api\V1;

use App\User;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

use App\Repositories\UserRepository;

class AuthController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->user->register([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
            ]);

            return $this->user->login($user);
        } catch (\Throwable $error) {
            return response()->json(['error' => $error->getMessage()], 422);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = User::findOrFail($request->only(['email', 'password']));

            return $this->user->login($user);
        } catch (\Throwable $error) {
            return response()->json(['error' => $error->getMessage()], 422);
        }
    }

    public function me()
    {
        $user = $this->user->getUserById(auth('api')->user()->id);

        return response()->json($user);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
