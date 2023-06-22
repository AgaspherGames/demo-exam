<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AdminController::class, 'loginView'])->name('login');
Route::post('/login', [AdminController::class, 'login']);

Route::group(["middleware" => "auth.admin"], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admins');

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/user/{username}', [UserController::class, 'show'])->name('user');
    Route::post('/user/{username}/ban', [UserController::class, 'ban'])->name('ban');

    Route::get('/games', [GameController::class, 'index'])->name('games');
    Route::get('/game/{slug}', [GameController::class, 'show'])->name('game');
    Route::delete('/game/{slug}/delete', [GameController::class, 'destroy'])->name('game.delete');

    Route::delete('/game/{slug}/clear', [GameController::class, 'clearScores'])->name('game.clear');
    Route::delete('/score/{id}', [GameController::class, 'clearScore'])->name('game.clearScore');
    Route::delete('/game/{slug}/user/{user_id}', [GameController::class, 'clearUserScore'])->name('game.clearUserScore');
});
