<?php

use App\Http\Controllers\Api\AssetController;

Route::get('/asset/{token}', AssetController::class)->name('asset');

Route::namespace('App\Http\Controllers')->group(function() {
    Auth::routes();
});

Route::get('/', \App\Http\Controllers\HomeController::class . '@index')->name('home');
Route::get('/home', \App\Http\Controllers\HomeController::class . '@index');
//Route::get("/radio");
