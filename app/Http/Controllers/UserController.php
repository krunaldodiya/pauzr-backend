<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Requests\UpdateUser;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        try {
            $image_path = Storage::disk('public')->put("assets", $request->image);
            auth('api')->user()->update(['avatar' => $image_path]);
            $user = $this->user->getUserById(auth('api')->user()->id);
            return response(['user' => $user], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
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
