<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Requests\UpdateUser;

use App\User;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use App\Image;
use App\Follow;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function followUser(Request $request)
    {
        $user = auth('api')->user();

        $following_id = $request->following_id;

        Follow::create(['follower_id' => $user->id, 'following_id' => $following_id]);

        $user = $this->user->getUserById($request->user_id);

        return ['user' => $user];
    }

    public function unfollowUser(Request $request)
    {
        $user = auth('api')->user();

        $following_id = $request->following_id;

        Follow::where(['follower_id' => $user->id, 'following_id' => $following_id])->delete();

        $user = $this->user->getUserById($request->user_id);

        return ['user' => $user];
    }

    public function me()
    {
        $user = $this->user->getUserById(auth('api')->user()->id);

        return ['user' => $user];
    }

    public function guest(Request $request)
    {
        $user = $this->user->getUserById($request->user_id);

        return ['user' => $user];
    }

    public function getUserGallery(Request $request)
    {
        $images = Image::where('user_id', $request->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return ['images' => $images];
    }

    public function uploadAvatar(Request $request)
    {
        $authUser = auth('api')->user();

        try {
            Cloudder::upload($request->image, null);

            $data = Cloudder::getResult();
            $url = $data['secure_url'];

            Image::where([
                'user_id' => $authUser->id,
                'type' => 'avatar',
            ])->update(['default' => false]);

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
