<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\User;

class TestController extends Controller
{
    public $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function check(Request $request)
    {
        $users = User::with('country')->get();

        foreach ($users as $user) {
            $cc = $user['country']['phonecode'] . $user['mobile'];
            $user->update(['mobile_cc' => $cc]);
        }

        return 'done';
    }
}
