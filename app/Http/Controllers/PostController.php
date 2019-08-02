<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use App\Post;
use App\PostEarning;
use App\Notifications\PostLiked;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostCreated;

class PostController extends Controller
{
    public function getPosts(Request $request)
    {
        $posts = Post::with('owner', 'likes.user.city', 'earnings')
            ->where('user_id', $request->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return ['posts' => $posts];
    }

    public function uploadImage(Request $request)
    {
        try {
            Cloudder::upload($request->image, null);
            $data = Cloudder::getResult();

            return ['name' => $data['secure_url']];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function toggleLike(Request $request)
    {
        $user = auth('api')->user();

        $post = Post::with('owner', 'likes.user.city', 'earnings')
            ->where(['id' => $request->post_id])
            ->first();

        $toggle = $user->favorites()->toggle($post);

        if ($toggle['attached']) {
            Notification::send($post->owner, new PostLiked($user->toArray(), $post->toArray()));
        }

        if ($toggle['detached']) {
            $post->owner->notifications()
                ->where('data->user_id', $user->id)
                ->where('data->post_id', $post->id)
                ->delete();
        };

        return response(['post' => $post], 200);
    }

    public function getPostDetail(Request $request)
    {
        $post = Post::with('owner', 'likes.user.city', 'earnings')
            ->where(['id' => $request->post_id])
            ->first();

        return response(['post' => $post], 200);
    }

    public function redeemPoints(Request $request)
    {
        $user = auth('api')->user();

        $post = Post::where(['id' => $request->post_id])->first();

        $earnings = PostEarning::create([
            'user_id' => $user->id,
            'post_id' => $request->post_id,
            'points' => $post->likes()->count(),
            'redeemed' => true,
        ]);

        $post = Post::with('owner', 'likes.user.city', 'earnings')
            ->where(['id' => $request->post_id])
            ->first();

        $transaction = $user->createTransaction($post->likes()->count(), 'deposit', ['description' => "Earning from post"]);
        $user->withdraw($transaction->transaction_id);

        return response(['post' => $post], 200);
    }

    public function deletePost(Request $request)
    {
        $user = auth('api')->user();

        Post::where(['id' => $request->post_id])->delete();

        $user->notifications()
            ->where('data->user_id', $user->id)
            ->where('data->post_id', $request->post_id)
            ->delete();

        return response(['success' => true], 200);
    }

    public function editPost(Request $request)
    {
        Post::where(['id' => $request->postId])
            ->update([
                'description' => $request->description ? $request->description : null,
                'url' => $request->photo,
            ]);

        $post = Post::with('owner', 'likes.user.city', 'earnings')->where('id', $request->postId)->first();

        return response(['post' => $post], 200);
    }

    public function createPost(Request $request)
    {
        $user = auth('api')->user();

        try {
            $post = Post::create([
                'user_id' => $user->id,
                'url' => $request->photo,
                'description' => $request->description ? $request->description : null,
                'type' => 'post',
                'default' => false,
            ]);

            $post = Post::with('owner', 'likes.user.city', 'earnings')->where('id', $post->id)->first();

            Notification::send($user->followers, new PostCreated($user->toArray(), $post->toArray()));

            return response(['post' => $post], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
