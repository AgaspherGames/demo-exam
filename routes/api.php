<?php

use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\ScoreController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('/v1')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/signin', [UserController::class, 'signin']);
        Route::post('/signup', [UserController::class, 'signup']);

        Route::group(["middleware" => "auth:sanctum"], function () {
            Route::post('/signout', [UserController::class, 'signout']);
        });
    });

    Route::get('/games', [GameController::class, 'index']);
    Route::get('/games/{slug}', [GameController::class, 'show']);

    Route::get('/users/{username}', [UserController::class, 'show']);
    Route::get('/games/{slug}/scores', [ScoreController::class, 'getByGame']);

    // Route::group(["middleware"=>"auth:sanctum"], function(){
    Route::group(["middleware" => "auth:sanctum"], function () {
        Route::group(["middleware" => "api.ban"], function () {
            Route::post('/games', [GameController::class, 'store']);
            Route::post('/games/{slug}/upload', [GameController::class, 'upload']);
            Route::put('/games/{slug}', [GameController::class, 'edit']);
            Route::delete('/games/{slug}', [GameController::class, 'destroy']);
            Route::post('/games/{slug}/scores', [ScoreController::class, 'store']);
        });
    });
});
