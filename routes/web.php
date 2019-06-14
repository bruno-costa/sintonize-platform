<?php

use App\Http\Controllers\AssetController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/asset/{token}', AssetController::class)->name('asset');
