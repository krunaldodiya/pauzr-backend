<?php

Route::get('/test/check', 'TestController@check');

Route::group(['namespace' => 'Api\V1'], function ($router) {
    Route::get('login/{driver}', 'SocialController@redirectToProvider');
    Route::get('callback/{driver}', 'SocialController@handleProviderCallback');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!nova|admin).*$');
