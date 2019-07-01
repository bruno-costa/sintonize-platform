<?php

use App\Http\Controllers\Api\AppAuthController;
use App\Http\Controllers\Api\RadioContentController;
use App\Http\Controllers\Api\RadioContentParticipateController;
use App\Http\Controllers\Api\RadioListController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserAppParticipationController;

Route::get('/me', AppAuthController::class);
Route::post('/register', RegisterController::class);

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::get('/me/participation', UserAppParticipationController::class);
    Route::get('/radios/all', RadioListController::class);
    Route::get('/radio/show/{id}', RadioContentController::class);
    Route::post('/radio/content/{id}/participate', RadioContentParticipateController::class);
});
