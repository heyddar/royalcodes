<?php

use Illuminate\Support\Facades\Route;


Route::resource('threads' , 'Api\v1\Thread\ThreadController');

Route::prefix('/threads')->group(function (){
    Route::resource('answers' , 'Api\v1\Thread\AnswerController');

    Route::post('/{thread}/subscribe' , 'Api\v1\Thread\SubscribeController@subscribe')->name('subscribe');
    Route::post('/{thread}/unsubscribe' , 'Api\v1\Thread\SubscribeController@unsubscribe')->name('unsubscribe');
});
