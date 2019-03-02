<?php

Route::get('/test', 'HomeController@test');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!nova).*$');