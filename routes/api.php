<?php

Route::group(['prefix' => 'home'], function () {
    Route::post('/init', 'HomeController@getInitialData')->middleware("auth:api");
    Route::post('/cities', 'HomeController@getCities')->middleware("auth:api");
    Route::post('/countries', 'HomeController@getCountries');
    Route::post('/quotes', 'HomeController@getQuotes');
    Route::post('/keywords', 'HomeController@getAdsKeywords');
});

Route::group(['prefix' => 'ads', 'middleware' => 'auth:api'], function () {
    Route::post('/impression', 'HomeController@setAdImpression');
});

Route::get('/push/deploy', 'HomeController@deployPush');
Route::get('/invite/{sender_id}/{mobile}', 'HomeController@checkInvitation');
Route::get('/refer', 'HomeController@getRefer');

Route::group(['prefix' => 'otp', 'middleware' => 'guest:api'], function () {
    Route::post('/request-otp', 'OtpController@requestOtp');
    Route::post('/verify-otp', 'OtpController@verifyOtp');
});

Route::group(['prefix' => 'users', 'middleware' => 'auth:api'], function () {
    Route::post('/notifications', 'UserController@getNotifications');
    Route::post('/notifications/read', 'UserController@markNotificationAsRead');
    Route::post('/intro-completed', 'UserController@completeIntro');
    Route::post('/me', 'UserController@me');
    Route::post('/guest', 'UserController@guest');
    Route::post('/update', 'UserController@update');
    Route::post('/avatar/upload', 'UserController@uploadAvatar');
    Route::post('/follow', 'FollowController@followUser');
    Route::post('/unfollow', 'FollowController@unfollowUser');
    Route::post('/suggest', 'FollowController@suggest');
    Route::post('/search', 'FollowController@search');
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::post('/users/me', 'Api\V1\UserController@me');
});

Route::group(['prefix' => 'posts', 'middleware' => 'auth:api'], function () {
    Route::post('/redeem', 'PostController@redeemPoints');
    Route::post('/like', 'PostController@toggleLike');
    Route::post('/detail', 'PostController@getPostDetail');
    Route::post('/list', 'PostController@getPosts');
    Route::post('/feeds', 'PostController@getFeeds');
    Route::post('/create', 'PostController@createPost');
    Route::post('/edit', 'PostController@editPost');
    Route::post('/delete', 'PostController@deletePost');
    Route::post('/image/upload', 'PostController@uploadImage');
});

Route::group(['prefix' => 'timer', 'middleware' => 'auth:api'], function () {
    Route::post('/minutes', 'TimerController@getMinutesHistory');
    Route::post('/points', 'TimerController@getPointsHistory');
    Route::post('/rankings', 'TimerController@getRankings');
    Route::post('/winners', 'TimerController@getWinners');
    Route::post('/set', 'TimerController@setTimer');
});

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
