<?php

Auth::routes();

Route::get('/test/check', 'TestController@check');

Route::get('/users/list', 'HomeController@exportUsers');

Route::group(['namespace' => 'Api\V1'], function ($router) {
    Route::get('login/{driver}', 'SocialController@redirectToProvider');
    Route::get('callback/{driver}', 'SocialController@handleProviderCallback');
});

Route::get('/home', 'HomeController@home')->name('home');
Route::get('/terms', 'HomeController@terms')->name('terms');
Route::get('/privacy', 'HomeController@privacy')->name('privacy');

Route::get("/storage/{url}", "HomeController@getAssets")->name("get-assets-from-storage")->where('url', '.*$');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!nova|admin).*$');
