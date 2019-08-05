<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Requests\UpdateUser;

use App\User;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use App\Post;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostCreated;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function completeIntro()
    {
        $user = auth('api')->user();
        $intro_completed = User::where('id', $user->id)->update(['intro_completed' => true]);

        return ['intro_completed' => $intro_completed];
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

            $post = Post::with('owner', 'likes.user.city', 'earnings')->where('id', $post->id)->first();

            Notification::send($followers, new PostCreated($authUser->toArray(), $post->toArray()));

            $user = $this->user->getUserById($authUser->id);

            return response(['post' => $post, 'user' => $user], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getNotifications(Request $request)
    {
        $user = auth('api')->user();

        $notifications = $user
            ->notifications
            ->where('created_at', '>', Carbon::now()->subDays(30));

        return response(['notifications' => $notifications], 200);
    }

    public function markNotificationAsRead(Request $request)
    {
        $user = auth('api')->user();

        DatabaseNotification::where('id', $request->notification_id)->update(['read_at' => Carbon::now()]);

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
            'bio' => $request->bio,
            'status' => true,
        ]);

        $user = $this->user->getUserById($user->id);

        return ['user' => $user];
    }
}
