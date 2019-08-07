<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserContact;
use App\Follow;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserFollowed;
use App\Repositories\UserRepository;

class FollowController extends Controller
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

        try {
            Follow::create(['follower_id' => $user->id, 'following_id' => $following_id]);

            $following = User::find($following_id);
            Notification::send($following, new UserFollowed($following->toArray(), $user->toArray()));

            $user = $this->user->getUserById($user->id);
            $guest = $this->user->getUserById($guest_id);

            return ['user' => $user, 'guest' => $guest];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function unfollowUser(Request $request)
    {
        $user = auth('api')->user();

        $following_id = $request->following_id;
        $guest_id = $request->guest_id;

        try {
            Follow::where(['follower_id' => $user->id, 'following_id' => $following_id])->delete();


            $following = $this->user->getUserById($following_id);
            $following->notifications()
                ->where('data->following_id', $following->id)
                ->where('data->follower_id', $user->id)
                ->delete();

            $user = $this->user->getUserById($user->id);
            $guest = $this->user->getUserById($guest_id);

            return ['user' => $user, 'guest' => $guest];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function suggest()
    {
        $user = auth('api')->user();

        $already_following = $user->followings->pluck('following_id');

        $post_like_wise = $user->favorites->pluck('user_id');
        $city_wise = User::where('city_id', $user->city->id)->pluck('id');
        $contact_wise = UserContact::where('user_id', $user->id)->pluck('mobile_cc');

        $followable_users = User::where('id', '!=', $user->id)
            ->where('status', true)
            ->where(function ($query) use ($post_like_wise, $city_wise, $contact_wise) {
                return $query
                    ->whereIn('id', $post_like_wise)
                    ->orWhereIn('id', $city_wise)
                    ->orWhereIn('mobile_cc', $contact_wise);
            })
            ->whereNotIn('id', $already_following)
            ->get();

        return response(['followable_users' => $followable_users], 200);
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords;

        $users = User::where('name', 'LIKE', "%$keywords%")->get();

        return response(['users' => $users], 200);
    }
}
