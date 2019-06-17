<?php

use App\Http\Controllers\AssetController;

Route::get('/asset/{token}', AssetController::class)->name('asset');

Route::namespace('App\Http\Controllers')->group(function() {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Auth::routes();
});
