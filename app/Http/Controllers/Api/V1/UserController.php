<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Resources\V1\MeResource;
use App\User;

class UserController extends Controller
{
    public function me(Request $request)
    {
        $me = User::where('id', auth('api')->user()->id)->first();

        return new MeResource($me);
    }
}
