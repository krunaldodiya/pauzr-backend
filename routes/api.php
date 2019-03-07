<?php

Route::group(['namespace' => 'App\Http\Controllers\Api\V1', 'prefix' => 'v1'], function ($router) {
    Route::group(['middelware' => 'auth:api'], function ($router) {
        Route::group(['prefix' => 'auth'], function ($router) {
            Route::post('logout', 'AuthController@logout');
            Route::post('refresh', 'AuthController@refresh');
            Route::post('me', 'AuthController@me');
        });
    });

    Route::group(['middelware' => 'guest'], function ($router) {
        Route::group(['prefix' => 'auth'], function ($router) {
            Route::post('register', 'AuthController@register');
            Route::post('login', 'AuthController@login');
        });

        Route::post('testing', function () {
            return ['testing' => 'testing'];
        });
    });
});
