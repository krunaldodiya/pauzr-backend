<?php

Route::get('/test', 'TestController@test');

Route::get('login', 'TestController@redirectToProvider');

Route::get('login/callback', 'TestController@handleProviderCallback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!nova|admin).*$');