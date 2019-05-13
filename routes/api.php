<?php

Route::group(['prefix' => 'otp', 'middleware' => 'guest:api'], function () {
    Route::post('/request-otp', 'OtpController@requestOtp');
    Route::post('/verify-otp', 'OtpController@verifyOtp');
});

Route::group(['prefix' => 'users', 'middleware' => 'auth:api'], function () {
    Route::post('/me', 'UserController@me');
    Route::post('/update', 'UserController@update');
    Route::post('/avatar/upload', 'UserController@uploadAvatar');
});

Route::group(['prefix' => 'home', 'middleware' => 'auth:api'], function () {
    Route::post('/init', 'HomeController@getInitialData');
    Route::post('/professions', 'HomeController@getProfessions');
    Route::post('/locations', 'HomeController@getLocations');
});

Route::group(['prefix' => 'timer', 'middleware' => 'auth:api'], function () {
    Route::post('/minutes', 'TimerController@getMinutesHistory');
    Route::post('/points', 'TimerController@getPointsHistory');
});

Route::post('testing', function () {
    return ['testing' => 'testing'];
});
