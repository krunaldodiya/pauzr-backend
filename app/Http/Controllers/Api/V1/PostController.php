<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\GetFeedsCollection;
use App\Http\Resources\V1\GetPostsCollection;
use Illuminate\Http\Request;

use App\Post;

class PostController extends Controller
{
    public function getFeeds(Request $request)
    {
        $user = auth('api')->user();
        $followings = $user->followings->pluck('following_id');

        $feeds = Post::with('owner')
            ->whereIn('user_id', $followings)
            ->orWhere('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return new GetFeedsCollection($feeds);
    }

    public function getPosts(Request $request)
    {
        $posts = Post::with('owner')
            ->where('user_id', $request->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return new GetPostsCollection($posts);
    }
}
