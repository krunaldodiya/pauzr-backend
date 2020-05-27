<?php

// version v1

Route::group(['prefix' => 'v1'], function () {
    Route::post('/location/countries', 'Api\V1\LocationController@getCountries');
});

Route::group(['prefix' => 'v1', 'middleware' => 'guest:api'], function () {
    Route::post('/otp/request-otp', 'Api\V1\OtpController@requestOtp');
    Route::post('/otp/verify-otp', 'Api\V1\OtpController@verifyOtp');
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::post('/users/me', 'Api\V1\UserController@me');
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::post('/notifications/show', 'Api\V1\NotificationController@getNotifications');
    Route::post('/notifications/mark-as-read', 'Api\V1\NotificationController@markNotificationAsRead');
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::post('/posts/feeds', 'Api\V1\PostController@getFeeds');
    Route::post('/posts/list', 'Api\V1\PostController@getPosts');
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::post('/lotteries/winners', 'Api\V1\LotteryController@getWinners');
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::post('/home/quotes', 'Api\V1\HomeController@getQuotes');
});

Route::group(['prefix' => 'v1'], function () {
    Route::get('/category/all', 'Api\V1\CategoryController@getCategories');
    Route::get('/category/{category_id}/info', 'Api\V1\CategoryController@getCategoryInfo');
    Route::get('/category/{category_id}/stores', 'Api\V1\StoreController@getStoresByCategory');
    Route::get('/store/all', 'Api\V1\StoreController@getStores');
    Route::get('/store/{store_id}/info', 'Api\V1\StoreController@getStoreInfo');
    Route::get('/store/{store_id}/products', 'Api\V1\StoreController@getProductsByStore');
    Route::get('/product/{product_id}/info', 'Api\V1\ProductController@getProductInfo');
});

// version v1

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

Route::group(['prefix' => 'categories', 'middleware' => 'auth:api'], function () {
    Route::post('/all', 'CategoryController@categories');
});
