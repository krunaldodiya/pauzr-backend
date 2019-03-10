<?php

Route::get('/test', 'TestController@test');

Route::get('login/google', 'TestController@redirectToProvider');

Route::get('login/google/callback', 'TestController@handleProviderCallback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!nova|admin).*$');