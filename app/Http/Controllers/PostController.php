<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use JD\Cloudder\Facades\Cloudder;

class PostController extends Controller
{
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

    public function editPost(CreateGroup $request)
    {
        Image::where(['id' => $request->postId])
            ->update([
                'description' => $request->description ?? null,
                'url' => $request->photo,
            ]);

        $post = Image::with('user')->where('id', $request->postId)->first();

        return response(['post' => $post], 200);
    }

    public function createPost(Request $request)
    {
        $user = auth('api')->user();

        try {
            $post = Image::create([
                'user_id' => $user->id,
                'url' => $request->photo,
                'type' => 'post',
                'default' => false,
            ]);

            $post = Image::with('user')->where('id', $post->id)->first();

            return response(['post' => $post], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
