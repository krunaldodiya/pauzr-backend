<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\User;
use Carbon\Carbon;

class UserRepository implements UserRepositoryInterface
{
    public function getUserById($user_id)
    {
        return User::with([
            'city.state.country',
            'state',
            'country',
            'level',
            'wallet',
            'followers' => function ($query) {
                return $query->paginate(500);
            },
            'followings' => function ($query) {
                return $query->paginate(500);
            },
            'followers.follower_user',
            'followings.following_user',
            'posts' => function ($query) {
                return $query->paginate(300);
            },
            'posts.likes' => function ($query) {
                return $query->paginate(500);
            },
            'posts.likes.user'
        ])
            // ->with('paginated_posts')->paginate(300)
            // ->with('paginated_posts.likes')->paginate(500)
            // ->with('paginated_posts.likes.user')
            ->where(['id' => $user_id])
            ->first();
    }

    protected function register($request)
    {
        $mobile = $request->mobile;
        $phonecode = $request->country['phonecode'];

        $authUser = User::create([
            'mobile' => $mobile,
            'mobile_cc' => $phonecode . $mobile,
            'password' => bcrypt(str_random(8))
        ]);

        $user = $this->getUserById($authUser->id);

        return $this->login($user, $request);
    }

    protected function login($user, $request)
    {
        $fcm_token = $request->fcm_token;

        $country_id = $request->country['id'];

        $user->update(['fcm_token' => $fcm_token, 'country_id' => $country_id]);

        $token = auth('api')->tokenById($user->id);

        return $this->generateToken($token, $user);
    }

    public function basicAuth($request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::firstOrCreate(['email' => $email], [
            'email' => $email,
            'password' => $password
        ]);

        return $this->login($user, $request);
    }

    public function otpAuth($request)
    {
        $user = User::where(['mobile' => $request->mobile])->first();

        if ($user) {
            return $this->login($user, $request);
        }

        return $this->register($request);
    }

    public function refreshToken()
    {
        return $this->generateToken(auth('api')->refresh(), auth('api')->user());
    }

    public function generateToken($token, $user)
    {
        $authUser = $this->getUserById($user->id);

        return [
            'access_token' => $token,
            'user' => $authUser
        ];
    }
}
