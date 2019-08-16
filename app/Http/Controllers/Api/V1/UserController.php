<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Resources\V1\MeResource;

class UserController extends Controller
{
    public function me(Request $request)
    {
        $me = auth('api')->user();

        return new MeResource($me);
    }
}
