<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use App\Post;

class PostController extends Controller
{
    public function getPosts(Request $request)
    {
        $posts = Post::with('user')
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

    public function getPostDetail(Request $request)
    {
        $post = Post::with('user', 'likes')->where(['id' => $request->post_id])->first();

        return response(['post' => $post], 200);
    }

    public function deletePost(Request $request)
    {
        Post::where(['id' => $request->post_id])->delete();

        return response(['success' => true], 200);
    }

    public function editPost(CreateGroup $request)
    {
        Post::where(['id' => $request->postId])
            ->update([
                'description' => $request->description ? $request->description : null,
                'url' => $request->photo,
            ]);

        $post = Post::with('user')->where('id', $request->postId)->first();

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

            $post = Post::with('user')->where('id', $post->id)->first();

            return response(['post' => $post], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
