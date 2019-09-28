<?php

Auth::routes();

Route::get('/hello', 'TestController@check');

Route::get('/users/list', 'HomeController@exportUsers');

Route::group(['namespace' => 'Api\V1'], function ($router) {
    Route::get('login/{driver}', 'SocialController@redirectToProvider');
    Route::get('callback/{driver}', 'SocialController@handleProviderCallback');
});

Route::group(['prefix' => 'backup', 'middleware' => 'auth'], function () {
    Route::get("/list", "BackupController@backupList")->name("backup.list");
    Route::get("/run", "BackupController@backupRun")->name("backup.run");
    Route::get("/clean", "BackupController@backupClean")->name("backup.clean");
    Route::get("/download", "BackupController@backupDownload")->name("backup.download");
});

Route::get('/home', function ($router) {
    return view('home');
})->name('home');

Route::get('/terms', 'HomeController@terms')->name('terms');
Route::get('/privacy', 'HomeController@privacy')->name('privacy');

Route::get("/storage/{url}", "HomeController@getAssets")->name("get-assets-from-storage")->where('url', '.*$');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!nova|admin).*$');
