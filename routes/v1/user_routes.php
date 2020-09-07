<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Auth\AuthController;


Route::prefix('/users')->group(function (){

    Route::get('/leaderboards',[
        \App\Http\Controllers\Api\v1\User\UserController::class,
        'leaderboards'
    ])->name('user.leaderboards');

});
