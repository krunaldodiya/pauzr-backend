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

    public function create(Request $request)
    {
        $user = auth('api')->user();

        try {
            $post = Image::create([
                'user_id' => $user->id,
                'url' => $request->url,
                'type' => 'post',
                'default' => false,
            ]);

            return response(['post' => $post], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
