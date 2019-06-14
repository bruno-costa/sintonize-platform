<?php

use App\Http\Controllers\AppAuthController;
use App\Http\Controllers\RadioContentController;
use App\Http\Controllers\RadioContentParticipateController;
use App\Http\Controllers\RadioListController;
use App\Http\Controllers\RegisterController;

Route::get('/me', AppAuthController::class);
Route::post('/register', RegisterController::class);

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::get('/radios/all', RadioListController::class);
    Route::get('/radio/show/{id}', RadioContentController::class);
    Route::post('/radio/content/{id}/participate', RadioContentParticipateController::class);
});
