<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;

class HomeController extends Controller
{
    public function test()
    {
        $user = User::with('roles')->where('email', 'kunal.dodiya1@gmail.com')->first();
        $roles = Role::get();

        $is_admin = $user->roles->contains('name', ['admin', 'user']);
        return compact('is_admin', 'user', 'roles');
    }
}
