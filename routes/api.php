<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::prefix('v1')->group(function (){

    //Authentication Routes
    Route::prefix('/auth')->group(function (){
        Route::post('/register','Api\v01\Auth\AuthController@register')->name('auth.register');
        Route::post('/login','Api\v01\Auth\AuthController@login')->name('auth.login');
        Route::get('/user','Api\v01\Auth\AuthController@user')->name('auth.user');
        Route::post('/logout','Api\v01\Auth\AuthController@logout')->name('auth.logout');
    });
    //Channel Routes
    Route::prefix('/channel')->group(function (){
        Route::get('/index','Api\v01\Channel\ChannelController@index')->name('channel.index');
        Route::post('/create','Api\v01\Channel\ChannelController@create')->name('channel.create');
    });
});
