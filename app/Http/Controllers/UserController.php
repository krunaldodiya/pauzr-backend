<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Requests\UpdateUser;

use App\User;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use App\Follow;
use App\Post;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserFollowed;
use App\Notifications\PostCreated;
use Carbon\Carbon;

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
        $guest_id = $request->guest_id;

        Follow::create(['follower_id' => $user->id, 'following_id' => $following_id]);

        $user = $this->user->getUserById($user->id);
        $guest = $this->user->getUserById($guest_id);
        $following = $this->user->getUserById($following_id);

        Notification::send($following, new UserFollowed($following->toArray(), $user->toArray()));

        return ['user' => $user, 'guest' => $guest];
    }

    public function unfollowUser(Request $request)
    {
        $user = auth('api')->user();

        $following_id = $request->following_id;
        $guest_id = $request->guest_id;

        Follow::where(['follower_id' => $user->id, 'following_id' => $following_id])->delete();

        $user = $this->user->getUserById($user->id);
        $guest = $this->user->getUserById($guest_id);
        $following = $this->user->getUserById($following_id);

        $following->notifications()
            ->where('data->following_id', $following->id)
            ->where('data->follower_id', $user->id)
            ->delete();

        return ['user' => $user, 'guest' => $guest];
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

    public function uploadAvatar(Request $request)
    {
        $authUser = auth('api')->user();

        $followers = $authUser->followers()->with('follower_user')->get()->pluck('follower_user');

        try {
            Cloudder::upload($request->image, null);

            $data = Cloudder::getResult();

            $url = $data['secure_url'];

            Post::where([
                'user_id' => $authUser->id,
                'type' => 'avatar',
            ])->update(['default' => false]);

            $post = Post::create([
                'user_id' => $authUser->id,
                'url' => $url,
                'default' => true,
            ]);

            Notification::send($followers, new PostCreated($authUser->toArray(), $post->toArray()));

            $user = $this->user->getUserById($authUser->id);

            return response(['user' => $user], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getNotifications(Request $request)
    {
        $user = auth('api')->user();

        $notifications = $user->notifications->where('created_at', '>', Carbon::now()->subDays(30));

        return response(['notifications' => $notifications], 200);
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
