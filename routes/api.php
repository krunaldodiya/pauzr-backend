<?php

Route::group(['prefix' => 'error'], function () {
    Route::post('/notify', 'HomeController@notifyError');
});

Route::group(['prefix' => 'otp', 'middleware' => 'guest:api'], function () {
    Route::post('/request-otp', 'OtpController@requestOtp');
    Route::post('/verify-otp', 'OtpController@verifyOtp');
});

Route::group(['prefix' => 'users', 'middleware' => 'auth:api'], function () {
    Route::post('/me', 'UserController@me');
    Route::post('/update', 'UserController@update');
    Route::post('/avatar/upload', 'UserController@uploadAvatar');
});

Route::group(['prefix' => 'home'], function () {
    Route::post('/init', 'HomeController@getInitialData')->middleware("auth:api");
    Route::post('/cities', 'HomeController@getCities')->middleware("auth:api");
    Route::post('/countries', 'HomeController@getCountries');
});

Route::group(['prefix' => 'timer', 'middleware' => 'auth:api'], function () {
    Route::post('/minutes', 'TimerController@getMinutesHistory');
    Route::post('/points', 'TimerController@getPointsHistory');
    Route::post('/rankings', 'TimerController@getRankings');
    Route::post('/winners', 'TimerController@getWinners');
    Route::post('/set', 'TimerController@setTimer');
});

Route::get('/invite/{sender_id}/{mobile}', 'HomeController@checkInvitation');

Route::group(['prefix' => 'groups', 'middleware' => 'auth:api'], function () {
    Route::post('/exit', 'GroupController@exitGroup');
    Route::post('/delete', 'GroupController@deleteGroup');
    Route::post('/create', 'GroupController@createGroup');
    Route::post('/edit', 'GroupController@editGroup');
    Route::post('/get', 'GroupController@get');
    Route::post('/add-participants', 'GroupController@addParticipants');
    Route::post('/remove-participants', 'GroupController@removeParticipants');
    Route::post('/sync-contacts', 'GroupController@syncContacts');
    Route::post('/image/upload', 'GroupController@uploadImage');
});

Route::post('testing', function () {
    return ['testing' => 'testing'];
});
