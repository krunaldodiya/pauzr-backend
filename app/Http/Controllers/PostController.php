<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use JD\Cloudder\Facades\Cloudder;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $user = auth('api')->user();

        try {
            Cloudder::upload($request->image, null);

            $data = Cloudder::getResult();

            $url = $data['secure_url'];

            $post = Image::create([
                'user_id' => $user->id,
                'url' => $url,
                'type' => 'post',
                'default' => false,
            ]);

            return response(['post' => $post], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
