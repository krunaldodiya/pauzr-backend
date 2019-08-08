<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use App\User;
use App\UserContact;
use Illuminate\Support\Arr;
use App\Post;
use App\Favorite;

class TestController extends Controller
{
    public $userRepository;
    public $timerRepository;

    public function __construct(UserRepository $userRepository, TimerRepository $timerRepository)
    {
        $this->userRepository = $userRepository;
        $this->timerRepository = $timerRepository;
    }

    public function check(Request $request)
    {
        if (!$request->email) {
            return response(['error' => "Enter your email"]);
        }

        if (!$request->action) {
            return response(['error' => "Enter some action"]);
        }

        $user = User::with('posts')
            ->where(['email' => $request->email])
            ->first();

        if ($request->action == 'show_posts') {
            return $user->posts;
        }

        if ($request->action == 'give_likes') {
            if ($request->post_id) {
                $post = Post::with('likes')->where('id', $request->post_id)->first();

                $users = User::whereNotIn('id', $post->likes->pluck('user_id'))->limit(50)->pluck('id');

                $data = collect($users)
                    ->map(function ($user) use ($post) {
                        return [
                            'post_id' => $post->id,
                            'user_id' => $user
                        ];
                    })
                    ->toArray();

                Favorite::insert($data);

                return response(['error' => "Done"]);
            }

            return response(['error' => "Enter post id"]);
        }
    }
}
