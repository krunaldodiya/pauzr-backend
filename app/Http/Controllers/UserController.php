<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function me()
    {
        $user = $this->user->getUserById(auth('api')->user()->id);

        return ['user' => $user];
    }
}
