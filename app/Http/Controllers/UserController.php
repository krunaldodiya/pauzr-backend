<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Requests\UpdateUser;

use App\User;
use App\Profession;
use App\Location;

use Carbon\Carbon;

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

    public function update(UpdateUser $request)
    {
        $user_id = auth('api')->user()->id;

        User::where('id', $user_id)->update([
            'name' => $request->name,
            'gender' => $request->gender,
            'dob' => Carbon::create($request->dob),
            'email' => $request->email,
            'location_id' => $request->location['id'],
            'status' => true
        ]);

        $user = $this->user->getUserById($user_id);

        return ['user' => $user];
    }
}
