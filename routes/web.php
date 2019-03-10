<?php

Route::get('/test', 'TestController@test');

Route::get('login/{driver}', 'TestController@redirectToProvider');

Route::get('callback/{driver}', 'TestController@handleProviderCallback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!nova|admin).*$');