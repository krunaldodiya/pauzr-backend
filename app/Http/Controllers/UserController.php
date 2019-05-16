<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Requests\UpdateUser;

use App\User;

use Carbon\Carbon;
use Illuminate\Http\Request;

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

    public function uploadAvatar(Request $request)
    {
        $image = $request->image;
        $name = $image->getClientOriginalName();

        $image->move("users", $name);
        auth('api')->user()->update(['avatar' => $name]);

        $user = $this->user->getUserById(auth('api')->user()->id);
        return ['user' => $user];
    }

    public function update(UpdateUser $request)
    {
        $user_id = auth('api')->user()->id;

        User::where('id', $user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'location_id' => $request->location_id,
            'status' => true
        ]);

        $user = $this->user->getUserById($user_id);

        return ['user' => $user];
    }
}
