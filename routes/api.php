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
    Route::post('/guest', 'UserController@guest');
    Route::post('/update', 'UserController@update');
    Route::post('/avatar/upload', 'UserController@uploadAvatar');
    Route::post('/follow', 'UserController@followUser');
    Route::post('/unfollow', 'UserController@unfollowUser');
});

Route::group(['prefix' => 'posts', 'middleware' => 'auth:api'], function () {
    Route::post('/list', 'PostController@getPosts');
    Route::post('/create', 'PostController@createPost');
    Route::post('/edit', 'PostController@editPost');
    Route::post('/delete', 'PostController@deletePost');
    Route::post('/image/upload', 'PostController@uploadImage');
});

Route::group(['prefix' => 'ads', 'middleware' => 'auth:api'], function () {
    Route::post('/impression', 'HomeController@setAdImpression');
});

Route::group(['prefix' => 'home'], function () {
    Route::post('/init', 'HomeController@getInitialData')->middleware("auth:api");
    Route::post('/cities', 'HomeController@getCities')->middleware("auth:api");
    Route::post('/countries', 'HomeController@getCountries');
    Route::post('/quotes', 'HomeController@getQuotes');
    Route::post('/keywords', 'HomeController@getAdsKeywords');
});

Route::group(['prefix' => 'timer', 'middleware' => 'auth:api'], function () {
    Route::post('/minutes', 'TimerController@getMinutesHistory');
    Route::post('/points', 'TimerController@getPointsHistory');
    Route::post('/rankings', 'TimerController@getRankings');
    Route::post('/winners', 'TimerController@getWinners');
    Route::post('/set', 'TimerController@setTimer');
});

Route::get('/invite/{sender_id}/{mobile}', 'HomeController@checkInvitation');
Route::get('/refer', 'HomeController@getRefer');

Route::group(['prefix' => 'lotteries', 'middleware' => 'auth:api'], function () {
    Route::post('/get', 'LotteryController@getLotteries');
    Route::post('/winners', 'LotteryController@getLotteryWinners');
    Route::post('/history', 'LotteryController@getLotteryHistory');
    Route::post('/withdraw', 'LotteryController@withdrawAmount');
});

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
