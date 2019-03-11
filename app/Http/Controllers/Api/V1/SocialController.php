<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Repositories\UserRepository;

class SocialController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function redirectToProvider(Request $request)
    {
        $scopes = [
            'facebook' => ['public_profile', 'email'],
            'google' => [
                'https://www.googleapis.com/auth/plus.me',
                'https://www.googleapis.com/auth/plus.login',
                'https://www.googleapis.com/auth/plus.profile.emails.read'
            ],
        ];

        $driver = $request->driver;
        return Socialite::driver($driver)->scopes($scopes[$driver])->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $driver = $request->driver;

        $data = Socialite::driver($driver)->stateless()->user();

        $user = $this->registerViaSocialNetwork($data);

        return view('response', ['user' => $user]);
    }

    public function registerViaSocialNetwork($data)
    {
        dd(isset($data->user['gender']) ? ucfirst($data->user['gender']) : "Male");

        $user = $this->user->register([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt(str_random(8)),
            'gender' => isset($data->user['gender']) ? ucfirst($data->user['gender']) : "Male",
            'avatar' => $data->avatar,
        ]);

        return $this->user->login($user);
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
