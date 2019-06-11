<?php

use App\Http\Controllers\AppAuthController;
use App\Http\Controllers\RegisterController;

Route::get('/me', AppAuthController::class);

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::post('/register', RegisterController::class);
    Route::get('/radios', function() {});
});
