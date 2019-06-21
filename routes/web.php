<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Adm\RadioController;

Route::get('/asset/{token}', AssetController::class)->name('asset');

Route::namespace('App\Http\Controllers')->group(function () {
    Auth::routes();
});

Route::middleware('auth')->group(function() {
    Route::prefix('adm')->group(function() {
        Route::resource('radio', RadioController::class);
    });
    Route::get('/', HomeController::class . '@index')->name('home');
    Route::get('/home', HomeController::class . '@index');
});
//Route::get('/radio', RadioController::class . "@index");
