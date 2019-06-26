<?php

use App\Http\Controllers\Adm\DashUserController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Adm\RadioController;
use App\Http\Controllers\UserRadioContentController;
use App\Http\Middleware\UserRadioMiddleware;

Route::get('/asset/{token}', AssetController::class)->name('asset');

Route::namespace('App\Http\Controllers')->group(function () {
    Auth::routes();
});
Route::post('block', '\App\Http\Controllers\Auth\LoginController@blockLogout')->name('block');

Route::middleware('auth')->group(function () {
    Route::prefix('adm')->group(function () {
        Route::resource('radio', RadioController::class);
        Route::resource('dash-user', DashUserController::class);
    });
    Route::get('/', HomeController::class . '@index')->name('home');
    Route::get('/home', HomeController::class . '@index');

    Route::middleware(UserRadioMiddleware::class)->group(function () {
        Route::resource('content', UserRadioContentController::class);
    });

});
