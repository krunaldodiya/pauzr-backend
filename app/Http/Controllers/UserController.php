<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Requests\UpdateUser;

use App\User;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use App\Image;

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
        $authUser = auth('api')->user();

        try {
            Cloudder::upload($request->image, null);

            $data = Cloudder::getResult();
            $url = $data['secure_url'];

            $authUser->update(['avatar' => $url]);

            Image::create([
                'user_id' => $authUser->id,
                'url' => $url,
                'default' => true,
            ]);

            $user = $this->user->getUserById($authUser->id);

            return response(['user' => $user], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(UpdateUser $request)
    {
        $user = auth('api')->user();

        User::where('id', $user->id)->update([
            'name' => $request->name,
            'email' => $request->email ? $request->email : $user->email,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'country_id' => $request->country_id,
            'status' => true
        ]);

        $user = $this->user->getUserById($user->id);

        return ['user' => $user];
    }
}
